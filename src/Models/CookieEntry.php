<?php

namespace Kraftausdruck\Models;

use Kraftausdruck\Models\CookieCategory;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;

class CookieEntry extends DataObject
{
    private static $singular_name = 'CookieEntry';

    private static $table_name = 'CookieEntry';

    private static $db = [
        'Title' => 'Varchar',
        'CookieKey' => 'Varchar',
        'Provider' => 'Varchar',
        'Purpose' => 'Text',
        'Policy' => 'Varchar',
        'CookieName' => 'Varchar',
        'Default' => 'Enum("false,true", "false")',
        'OptOut' => 'Enum("false,true", "false")',
        'Time' => 'Varchar',
        'SortOrder' => 'Int'
    ];

    private static $has_one = [
        'CookieCategory' => CookieCategory::class
    ];

    private static $default_sort = 'SortOrder ASC';

    private static $field_labels = [];

    public function getCMSValidator()
    {
        return new RequiredFields([
            'Title',
            'Provider',
            'Purpose'
        ]);
    }

    public function CookieNamesJS()
    {
        if($this->CookieName == null) return '[]';

        $names = explode(',', $this->CookieName);
        $r = '[';
        if (count($names)) {
            $i = 0;
            $len = count($names);
            foreach($names as $name) {
                $r .= '"' . $name . '"';
                if ($i == $len - 1) {
                    $r .= ']';
                } else {
                    $r .= ', ';
                }
                $i++;
            }
        }
        return $r;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('SortOrder');

        return $fields;
    }
}
