<?
foreach ($templates as $template)
{
echo '<p><a href="/index.php/dogovor_archiv/documents/add/?templ_id='.$template->_id.'">'.$template->description.'</a></p>';
}
?>
