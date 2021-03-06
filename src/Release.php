<?php

namespace MJErwin\ParseAChangelog;

use Parsedown;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 *
 * @method getAdded()
 * @method getChanged()
 * @method getDeprecated()
 * @method getRemoved()
 * @method getFixed()
 * @method getSecurity()
 *
 */
class Release
{
    protected $content;
    protected $version;
    protected $date;

    /**
     * Release constructor.
     *
     * @param $content
     */
    public function __construct($content)
    {
        $this->content = $content;

        $heading_line = isset($this->content[0]) ? $this->content[0] : null;

        if ($heading_line)
        {
            preg_match('/^## (\[?)(?<version>[^\s\[\]#]*)(\]?)( - (?<date>[0-9]{4}-[0-9]{2}-[0-9]{2}))?$/', $heading_line, $matches);

            $this->version = isset($matches['version']) ? $matches['version'] : null;
            $this->date = isset($matches['date']) ? $matches['date'] : null;
        }
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    function __call($name, $arguments)
    {
        if (substr($name, 0, 3) == 'get')
        {
            $requested = substr($name, 3);

            if (in_array($requested, $this->getMessageTypes()))
            {
                return call_user_func_array([$this, 'getMessageByType'], array_merge([$requested], $arguments));
            }
        }

        // Nothing found default to error
        trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    private function getMessageByType($type)
    {
        $messages = [];

        $matches = preg_grep(sprintf('/^### %s/', $type), $this->content);

        if (!empty($matches))
        {
            $start = key($matches) + 1;
            $remaining = array_slice($this->content, $start);
            $end = key(preg_grep(sprintf('/^##/', $type), $remaining));

            if ($end)
            {
                $end += $start;
            }
            else
            {
                $end = sizeof($this->content);
            }

            $lines = array_splice($this->content, $start, $end - $start);

            foreach($lines as $line)
            {
                if (preg_match('/^[\-](\s?)(?<message>.*)/', $line, $matches))
                {
                    $messages[] = $matches['message'];
                }
                else
                {
                    // Handle multi-line messages
                    end($messages);
                    $previous_message_index = key($messages);
                    if (isset($messages[$previous_message_index]) && $line)
                    {
                        $messages[$previous_message_index] .= "\n" . $line;
                    }
                }
            }
        }

        return $messages;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'version' => $this->getVersion(),
            'date' => $this->getDate(),
        ];

        foreach($this->getMessageTypes() as $type)
        {
            $data[strtolower($type)] = $this->getMessageByType($type);
        }

        return $data;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        $data = $this->toArray();

        return json_encode($data);
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        $content_string = implode("\n", $this->content);

        $md_parser = new Parsedown();

        return $md_parser->text($content_string);
    }

    /**
     * @return string
     */
    public function toXml()
    {
        $doc = new \DOMDocument('1.0', 'UTF-8');

        $changelog_elem = $doc->createElement('changelog');

        $changelog_elem->setAttribute('version', $this->getVersion());
        $changelog_elem->setAttribute('date', $this->getDate());

        foreach($this->getMessageTypes() as $type)
        {
            $type_elem = $doc->createElement(strtolower($type));

            $messages = $this->getMessageByType($type);

            foreach($messages as $message)
            {
                $message_elem = $doc->createElement('message', $message);
                $type_elem->appendChild($message_elem);
            }

            $changelog_elem->appendChild($type_elem);
        }

        $doc->appendChild($changelog_elem);

        return $doc->saveXML();
    }

    /**
     * @return string[]
     */
    private function getMessageTypes()
    {
        return [
            'Added',
            'Changed',
            'Deprecated',
            'Removed',
            'Fixed',
            'Security',
        ];
    }
}