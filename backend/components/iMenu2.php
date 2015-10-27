<?php
/**
 * Created by PhpStorm.
 * User: yuelei
 * Date: 15/10/26
 * Time: 下午4:24
 */
namespace backend\components;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
class iMenu2 extends Menu
{
    /**
     * @var array下级菜单 属性.如<ul>
     */
    public $submenuOptions = [];

    public $linkOptions = [];

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items,$itemOptions=true)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            if($itemOptions)
                $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            else
                $options = array_merge([],ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {

                $submenuOptions = array_merge($this->submenuOptions, ArrayHelper::getValue($item, 'submenuOptions', []));

                if($submenuOptions)
                {
                    $submenuTemplate = Html::tag('ul','{items}',$submenuOptions);
                }
                else
                {
                    $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                }
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items'], false),
                ]);
            }
            if ($tag === false) {
                $lines[] = $menu;
            } else {
                $lines[] = Html::tag($tag, $menu, $options);
            }
        }

        return implode("\n", $lines);
    }

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
    protected function renderItem($item)
    {
        //linkOptions
        $linkTemplate = $this->linkTemplate;
        $linkOptions =array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));
        if($linkOptions)
        {
            $linkOptions['href'] = isset($linkOptions['href']) ? $linkOptions['href'] : '{url}';
            $linkTemplate = Html::tag('a','{label}', $linkOptions);

        }

        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $linkTemplate);

            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }
    }

}