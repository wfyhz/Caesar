<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/17
 * Time: 18:17
 */
namespace backend\components;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
class iMenu extends Menu
{

	public $titleActiveCss = 'nav-header';
	public $subItemActiveCss = 'in';
	/**
	 * Recursively renders the menu items (without the container tag).
	 * @param array $items the menu items to be rendered recursively
	 * @return string the rendering result
	 */
	protected function renderItems($items)
	{
		$n = count($items);
		$lines = [];
		foreach ($items as $i => $item) {
			$options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
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
				if(isset($item['subMenuOptions']))
				{
					$subMeunOptions = $item['subMenuOptions'];
					$isSubItemActive = $this->isSubItemActive($item);
					$css = isset($subMeunOptions['class']) ? $subMeunOptions['class'] : '';
					$subMeunOptions['class'] = $isSubItemActive ? $css.' '.$this->subItemActiveCss : $css;
					$tempSubmenuTemplate = Html::tag('ul',"\n{items}\n", $subMeunOptions);
				}
				else
				{
					$tempSubmenuTemplate = $this->submenuTemplate;
				}
				$submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $tempSubmenuTemplate);
				$menu .= strtr($submenuTemplate, [
					'{items}' => $this->renderItems($item['items']),
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
		if (isset($item['url'])) {
			if(isset($item['titleOptions']))
			{
				$options = $item['titleOptions'];
				$options['href'] = '{url}';
				$isSubItemActive = $this->isSubItemActive($item);

				$options['class'] = $isSubItemActive ? $this->titleActiveCss : (isset($options['class']) ? $options['class'] : '');
				$linkTemplate = Html::tag('a','{label}', $options);
			}
			else
			{
				$linkTemplate = $this->linkTemplate;
			}
			$template = ArrayHelper::getValue($item, 'template', $linkTemplate);
			return strtr($template, [
				'{url}' => Html::encode(Url::to($item['url'])),
				'{label}' => $item['label'],
			]);
		} else {
			$template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

			return strtr($template, [
				'{label}' => $item['label'],
			]);
		}
	}

	/**
	 * Normalizes the [[items]] property to remove invisible items and activate certain items.
	 * @param array $items the items to be normalized.
	 * @param boolean $active whether there is an active child menu item.
	 * @return array the normalized menu items
	 */
	protected function normalizeItems($items, &$active)
	{
		foreach ($items as $i => $item) {
			if (isset($item['visible']) && !$item['visible']) {
				unset($items[$i]);
				continue;
			}
			if (!isset($item['label'])) {
				$item['label'] = '';
			}
			$encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
			$items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
			$hasActiveChild = false;
			if (isset($item['items'])) {
				$items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
				if (empty($items[$i]['items']) && $this->hideEmptyItems) {
					unset($items[$i]['items']);
					if (!isset($item['url'])) {
						unset($items[$i]);
						continue;
					}
				}
			}
			if (!isset($item['active'])) {
				if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
					$active = $items[$i]['active'] = true;
				} else {
					$items[$i]['active'] = false;
				}
			} elseif ($item['active']) {
				$active = true;
			}
		}

		return array_values($items);
	}

	/**
	 * Checks whether a menu item is active.
	 * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
	 * When the `url` option of a menu item is specified in terms of an array, its first element is treated
	 * as the route for the item and the rest of the elements are the associated parameters.
	 * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
	 * be considered active.
	 * @param array $item the menu item to be checked
	 * @return boolean whether the menu item is active
	 */
	protected function isItemActive($item)
	{
		if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
			$route = $item['url'][0];
			if ($route[0] !== '/' && Yii::$app->controller) {
				$route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
			}
			if (ltrim($route, '/') !== $this->route) {
				return false;
			}
			unset($item['url']['#']);
			if (count($item['url']) > 1) {
				$params = $item['url'];
				unset($params[0]);
				foreach ($params as $name => $value) {
					if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
						return false;
					}
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * 查看 子菜单里是否有活跃的项
	 * @param $item
	 * @return bool
	 */
	protected function isSubItemActive($item)
	{
		if(isset($item['items']))
		{
			foreach($item['items'] as $key=>$value)
			{
				if($value['active'])
				{
					return true;
				}
			}
		}

		return false;
	}
}