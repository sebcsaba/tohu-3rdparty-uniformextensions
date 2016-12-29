<?php

namespace ToHu;

use JFactory;

/**
 * Form edit oldalon, Scripts lapon az elso dobozba ird be ezt, es ez tovabbvezet a teljes folyamaton:
 * require_once JPATH_ROOT.DS.'thirdparty/uniformextensions/set_limits.php';help($formId);
 */

function help($formId) {
    echo '<pre>'.UniWrapper::scaffold($formId).'</pre>';
}

/**
 * $limits: array( field_id => array( label => limit ) )
 */
function set_limits($formId, array $limits) {
	$remove = UniWrapper::getItemsToRemove($formId, $limits);
	printJQueryToSetLimits($remove);
}

function printJQueryToSetLimits(array $jqueryExecs) {
	echo('<script>');
	echo('jQuery(document).ready(function() {');
	foreach ($jqueryExecs as $exec) {
		echo($exec);
	}
	echo('});');
	echo('</script>');
}

function getJQueryToExec($formId, $fieldId, $value, $fieldType) {
	if ($fieldType == 'dropdown') {
		$path = "div#jsn_form_$formId select#$fieldId option[value='".addslashes($value)."']";
		return "jQuery('".addslashes($path)."').remove();";
	}
	else if ($fieldType == 'choices') {
		$path = "div#jsn_form_$formId input[name='".$fieldId."'][value='".addslashes($value)."']";
		return "jQuery('".addslashes($path)."').closest('div.jsn-column-item').remove();";
	}
	else {
		return "throw 'Unknown fieldType: ".$fieldType."'";
	}
}

class UniWrapper
{
    /**
     * @param int $formId
     * @return UniField[]
     */
    public static function getFields($formId)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true)
            ->from('#__jsn_uniform_fields')
            ->select('field_id, field_type, field_title, field_settings')
            ->where([
                'form_id=' . (int)$formId,
                "field_type IN ('choices', 'dropdown', 'checkboxes')"
            ], "AND");

        $db->setQuery($query);
        return $db->loadObjectList('field_id', UniField::class);
    }

    public static function scaffold($formId)
    {
        $result = [
            'require_once "'.__FILE__.'";',
            '\ToHu\set_limits('.$formId.', [',
        ];
        foreach (self::getFields($formId) as $field) {
            $result [] = "\t// {$field->field_title}";
            $result [] = "\t{$field->field_id} => [".self::formatValues($field)."\t],";
        }
        $result[] = ']);';
        return implode(PHP_EOL, $result);
    }

    private static function formatValues(UniField $field)
    {
        $result = [PHP_EOL];
        foreach ($field->getValues() as $text) {
            $result [] = "\t\t'" .addslashes($text)."' => 0,";
        }
        return implode(PHP_EOL, $result) . PHP_EOL;
    }

	public static function getSubmissionCountsNormal($formId, $fieldId) {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true)
			->from('#__jsn_uniform_submission_data')
			->group('submission_data_value')
			->where('form_id=' . (int)$formId)
			->andWhere('field_id=' . (int)$fieldId)
			->select('submission_data_value, count(*) as cnt');
		$db->setQuery($query);
		return $db->loadAssocList('submission_data_value');
	}

	public static function getSubmissionCountsCheckboxes($formId, $fieldId) {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true)
			->from('#__jsn_uniform_submission_data')
			->where('form_id=' . (int)$formId)
			->andWhere('field_id=' . (int)$fieldId)
			->select('submission_data_value');
		$db->setQuery($query);
		$column = $db->loadColumn(0);
		$result = array();
		foreach ($column as $submission) {
			$values = json_decode($submission);
			if ($values === null) {
				$values = self::extraJsonParse($submission);
			}
			foreach ($values as $value) {
				$result[$value]++;
			}
		}
		$response = array();
		foreach ($result as $value => $count) {
			$response[$value] = array(
				'submission_data_value' => $value,
				'cnt' => $count
			);
		}
		return $response;
	}

	public static function getSubmissionCounts($formId, $fieldId, $fieldType) {
		if ('checkboxes' == $fieldType) {
			return self::getSubmissionCountsCheckboxes($formId, $fieldId);
		}
		else {
			return self::getSubmissionCountsNormal($formId, $fieldId);
		}
	}

	public static function getItemsToRemove($formId, array $limits) {
		$fields = UniWrapper::getFields($formId);
		$remove = array();
		foreach ($limits as $fieldId => $fieldLimits) {
			$field = $fields[$fieldId];
			$submissionCounts = UniWrapper::getSubmissionCounts($formId, $fieldId, $field->field_type);
			foreach ($fieldLimits as $text => $limit) {
				if ($limit > 0) {
					if (isset($submissionCounts[$text]) && $submissionCounts[$text]['cnt'] >= $limit) {
						$remove []= getJQueryToExec($formId, $fieldId, $text, $field->field_type);
					}
				}
			}
		}
		return $remove;
	}

	/**
	 * UniForm stores checkbox values not in a proper json-encoded format,
	 * but sometimes without quotation marks like '[Checkbox 2]'
	 */
	public static function extraJsonParse($listOfValues) {
		if (!preg_match('/^\[.*\]$/', $listOfValues)) {
			return null;
		}
		$str = substr($listOfValues,1,strlen($listOfValues)-2);
		$result = array();
		while (strlen($str) > 0) {
			if ('"' == substr($str, 0, 1)) {
				$p = strpos($str, '"', 1);
				if ($p === false) {
					return null;
				}
				if (($p+1 < strlen($str)) && substr($str, $p+1, 1) != ',') {
					return null;
				}
				$result []= substr($str, 1, $p);
				$str = substr($str, $p+2);
			}
			else {
				$p = strpos($str, ',');
				if ($p === false) {
					$result []= $str;
					$str = '';
				}
				else {
					$result []= substr($str, 0, $p);
					$str = substr($str, $p+1);
				}
			}
		}
		return $result;
	}

}

class UniField
{
    public $field_id;
    public $field_type;
    public $field_title;
    public $field_settings;

    public function getValues()
    {
        $settings = json_decode($this->field_settings, true);
        return array_map($this->getItemText(), $settings['options']['items']);
    }

    private function getItemText()
    {
        return function ($item) {
            return $item['text'];
        };
    }
}
