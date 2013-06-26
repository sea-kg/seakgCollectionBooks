<?
	include_once "../whc_index.php";
  include_once "../create_objects.php";

  $index = new whc_index();

  $index->exec("examples/config.php", create_objects);

?>