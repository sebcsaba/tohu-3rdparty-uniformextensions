<?php

/**
 * Form edit oldalon, Scripts lapon az elso dobozba ird be ezt, es ez tovabbvezet a teljes folyamaton:
 * require_once JPATH_ROOT.DS.'thirdparty/uniformextensions/set_limits.php';help($formId);
 */

function help($formId) {
    echo $formId;
/*
$db = JFactory::getDBO();
$db->setQuery($db->getQuery(true)->from('#__jsn_uniform_form_fields')->select('*')->where('form_id=' . (int) $formId))->where("field_type IN ('checkboxes','choices')");
$fields = $db->loadObject();
SELECT * FROM `j25_jsn_uniform_fields` WHERE `form_id` =49 and field_type IN ('checkboxes','choices','dropdown')
-- field_id, field_title, field_settings JSON
choices
{"id":1985,"type":"choices","position":"left_2","identify":"v_lassz_foglalkoz_st_30_a_vas_rnap_d_lel_ttre_","label":"V\u00e1lassz m\u0171helyfoglalkoz\u00e1st 31-e (h\u00e9tf\u0151) d\u00e9lut\u00e1nra:","instruction":"","options":{"label":"V\u00e1lassz m\u0171helyfoglalkoz\u00e1st 31-e (h\u00e9tf\u0151) d\u00e9lut\u00e1nra:","instruction":"","required":0,"randomize":0,"labelOthers":"Others","layout":"jsn-columns-count-one","items":[{"text":"L\u00e1thatatlan vil\u00e1g - Alus","checked":false},{"text":"V\u00e1rost\u00f6rt\u00e9neti s\u00e9ta - \u00c9ogil","checked":false},{"text":"Birodalom\u00e9p\u00edt\u0151k - Tot\u00f3 + Yzak + V-T\u00f3th Attila","checked":false},{"text":"B\u00e1li el\u0151k\u00e9sz\u00edt\u0151 - Feh\u00e9r Viki + Tony\u00f3","checked":false},{"text":"D\u00edsz k\u00e9sz\u00edt\u00e9s filcb\u0151l - Sil","checked":false},{"text":"Portr\u00e9rajzol\u00f3 m\u0171hely - Esztur","checked":false},{"text":"Innovat\u00edv lehet\u0151s\u00e9gek a gyerekkori IT oktat\u00e1sban - F\u00e9lix + Eszti","checked":false},{"text":"Egy betiltott k\u00f6nyv marg\u00f3j\u00e1ra: A Gy\u0171r\u0171k Ura \u00e9s a vall\u00e1s - Ankalimon","checked":false},{"text":"(egyik sem)","checked":false}],"value":"","paymentMoneyValue":"No","showPriceLabel":"No","customClass":"","itemAction":"","identify":"v_lassz_foglalkoz_st_30_a_vas_rnap_d_lel_ttre_"}}
dropdown
{"id":22,"type":"dropdown","position":"left_2","identify":"v_lasztott_sz_ll_s_t_pusa","label":"V\u00e1lasztott sz\u00e1ll\u00e1s t\u00edpusa","instruction":"","options":{"label":"V\u00e1lasztott sz\u00e1ll\u00e1s t\u00edpusa","instruction":"","required":"1","labelOthers":"Others","size":"jsn-input-fluid","items":[{"text":"- V\u00e1lassz -","checked":false},{"text":"\u00c1ltal\u00e1nos szoba 6-10 f\u0151s (alap\u00e1r) ","checked":false},{"text":"Pr\u00e9mium apartman 5+1 f\u0151s - 2 szob\u00e1nk\u00e9nt saj\u00e1t konyha \u00e9s f\u00fcrd\u0151szoba (12 000 Ft\/szoba kieg\u00e9sz\u00edt\u0151 d\u00edj)","checked":false},{"text":"Pr\u00e9mium apartman 4 f\u0151s - 2 szob\u00e1nk\u00e9nt saj\u00e1t konyha \u00e9s f\u00fcrd\u0151szoba: (12 000 Ft\/szoba kieg\u00e9sz\u00edt\u0151 d\u00edj)","checked":false},{"text":"2 f\u0151s szoba - nincs k\u00fcl\u00f6n konyha \u00e9s f\u00fcrd\u0151szoba (6000 Ft\/szoba kieg\u00e9sz\u00edt\u0151 d\u00edj)","checked":false},{"text":"Saj\u00e1t s\u00e1tor  (kedvezm\u00e9nyes d\u00edj \u2013 egyedi egyeztet\u00e9s alapj\u00e1n)","checked":false}],"value":"","customClass":"","itemAction":"{\"- V\u00e1lassz -\":{},\"\u00c1ltal\u00e1nos szoba 6-10 f\u0151s (alap\u00e1r) \":{},\"Pr\u00e9mium apartman 5+1 f\u0151s - 2 szob\u00e1nk\u00e9nt saj\u00e1t konyha \u00e9s f\u00fcrd\u0151szoba (12 000 Ft\/szoba kieg\u00e9sz\u00edt\u0151 d\u00edj)\":{\"showField\":[\"static_content_16\"]},\"Pr\u00e9mium apartman 4 f\u0151s - 2 szob\u00e1nk\u00e9nt saj\u00e1t konyha \u00e9s f\u00fcrd\u0151szoba: (12 000 Ft\/szoba kieg\u00e9sz\u00edt\u0151 d\u00edj)\":{\"showField\":[\"static_content_16\"]},\"2 f\u0151s szoba - nincs k\u00fcl\u00f6n konyha \u00e9s f\u00fcrd\u0151szoba (6000 Ft\/szoba kieg\u00e9sz\u00edt\u0151 d\u00edj)\":{},\"Saj\u00e1t s\u00e1tor  (kedvezm\u00e9nyes d\u00edj \u2013 egyedi egyeztet\u00e9s alapj\u00e1n)\":{\"showField\":[\"static_content_15\"]}}","firstItemAsPlaceholder":"1","identify":"v_lasztott_sz_ll_s_t_pusa"}}
checkboxes
{"id":24,"type":"checkboxes","position":"left_4","identify":"milyen_speci_lis_tkez_st_k_rsz_","label":"Milyen speci\u00e1lis \u00e9tkez\u00e9st k\u00e9rsz?","instruction":"A speci\u00e1lis \u00e9tkez\u00e9s d\u00edja magasabb lehet, mint a norm\u00e1l \u00e9trend\u00e9. A v\u00e1lasztott \u00e9tkez\u00e9si m\u00f3d a t\u00e1bor teljes idej\u00e9re vonatkozik - nem lehets\u00e9ges \u00e1tv\u00e1ltani a norm\u00e1l \u00e9tkez\u00e9sre.","options":{"label":"Milyen speci\u00e1lis \u00e9tkez\u00e9st k\u00e9rsz?","instruction":"A speci\u00e1lis \u00e9tkez\u00e9s d\u00edja magasabb lehet, mint a norm\u00e1l \u00e9trend\u00e9. A v\u00e1lasztott \u00e9tkez\u00e9si m\u00f3d a t\u00e1bor teljes idej\u00e9re vonatkozik - nem lehets\u00e9ges \u00e1tv\u00e1ltani a norm\u00e1l \u00e9tkez\u00e9sre.","required":0,"randomize":0,"allowOther":"1","layout":"jsn-columns-count-one","labelOthers":"M\u00e1s:","items":[{"text":"Veget\u00e1ri\u00e1nus","checked":false},{"text":"Glut\u00e9nmentes","checked":false},{"text":"Lakt\u00f3zmentes","checked":false}],"value":"","customClass":"","itemAction":"","identify":"milyen_speci_lis_tkez_st_k_rsz_"}}
*/
}

/**
 * $limits: array( field_id => array( label => limit ) )
 */
function set_limits($formId, array $limits) {
/*
SELECT count( * ) FROM `j25_jsn_uniform_submission_data` WHERE `form_id` =49 AND `field_id` =1985 AND `submission_data_value` = 'Láthatatlan világ - Alus'
*/
	$remove = array();
	$remove []= getJQueryToExec($formId, 2078, "Value 1", 'dropdown');
	$remove []= getJQueryToExec($formId, 2076, "Choice 2", 'choices');
	$remove []= getJQueryToExec($formId, 2077, "Checkbox 3", 'checkboxes');
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
	else if ($fieldType == 'checkboxes') {
		$path = "div#jsn_form_$formId input[name='".$fieldId."[]'][value='".addslashes($value)."']";
		return "jQuery('".addslashes($path)."').closest('div.jsn-column-item').remove();";
	}
	else {
		return "throw 'Unknown fieldType: ".$fieldType."'";
	}
}

?>
