<?php
namespace EPFL\Plugins\Gutenberg\FieldsOfResearchList;
require_once(dirname(__FILE__).'/../lib/utils.php');
require_once(dirname(__FILE__).'/../lib/language.php');
require_once(dirname(__FILE__).'/controller.php');
use \EPFL\Plugins\Gutenberg\Lib\Utils;
use function EPFL\Plugins\Gutenberg\Lib\Language\get_current_or_default_language;
define(__NAMESPACE__ . "\LABS_INFO_PROVIDER_URL", "https://wp-veritas.epfl.ch/api/v1/");
function epfl_fields_of_research_list_block($attributes) {
    # by default get all sites with at least a tag
    $lang = get_current_or_default_language();
    $url = LABS_INFO_PROVIDER_URL . 'tags/?type=field-of-research';
    $fields = Utils::get_items($url);
    ob_start();
?>
<div class="container-full">
  <div class="container">
    <ul class="list-group list-group-flush">
      <?php foreach($fields as $field): ?>
        <?php $name = ($lang == 'fr')?$field->name_fr:$field->name_en; ?>
        <?php $url  = ($lang == 'fr')?$field->url_fr:$field->url_en; ?>
      <li class="list-group-item">
          <a href="<?php echo esc_attr($url); ?>">
            <?php echo esc_html($name); ?>
          </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}