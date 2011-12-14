<?
require_once ("class_scraper.php");

// Get html --------
$o_sc = new scraper();
$s_url = 'http://finance.yahoo.com/q/hp?s=AMZN';
$s_user_agent = 'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.0.1) Gecko/20020921 Netscape/7.0';
$s_html = $o_sc->browse($s_url, $s_user_agent);

// Delimit start and end of patterns
$s_start_pattern = "Adj Close";
$s_end_pattern = "<small>";

// Pattern structure
$s_model = '<tr
<td
<field>
</td>
<td
<field>
</td>
<td
<field>
</td>
<td
<field>
</td>
<td
<field>
</td>
<td
<field>
</td>
<td
<field>
</td>
/tr>';

$a_result = $o_sc->extract($s_html, $s_start_pattern, $s_end_pattern, $s_model);
print_r ($a_result);

?>