<?

header("Access-Control-Allow-Origin: *");

function autoload($className)
{
//list comma separated directory name
$directory = array('', 'core/', 'models/', 'controllers/', 'core/Conexao/' ,'views/templates/');

//list of comma separated file format
$fileFormat = array('.php', '.class.php');



foreach ($directory as $current_dir)
{
  foreach ($fileFormat as $current_format)
  {

      $path = $current_dir.sprintf($current_format, $className);
      //echo file_exists($current_dir . $className. $current_format);
      if (file_exists($current_dir . $className. $current_format))
      {
          include dirname(__FILE__) . '/' . $current_dir . $className. $current_format;

          //return ;
      }
  }
}
}
spl_autoload_register('autoload');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$core = new Core();
$core->run();



?>