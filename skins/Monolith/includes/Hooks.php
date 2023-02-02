<?php
namespace Monolith;

use OutputPage;
use Skin;
use SkinTemplate;

class Hooks {
	public static function onOutputPageBodyAttributes( OutputPage $out, Skin $skin, &$bodyAttrs ) {
		$lang = $skin->getLanguage();
		if (
			$skin->getSkinName() === 'monolith' && (
				$lang->getCode() === 'de' ||
				in_array( 'de', $lang->getFallbackLanguages() )
			)
		) {
			$bodyAttrs['class'] .= ' monolith-capitalize-all-nouns';
		}
	}

	/**
	 * SkinTemplateNavigationUniversal hook handler
	 *
	 * @param SkinTemplate $skin
	 * @param array &$content_navigation
	 */
	public static function onSkinTemplateNavigationUniversal( SkinTemplate $skin, array &$content_navigation ) {
		$title = $skin->getTitle();
		if ( $skin->getSkinName() === 'monolith' ) {
			$tabs = [];
			$namespaces = $content_navigation['namespaces'];
			foreach ( $namespaces as $nsid => $attribs ) {
				$id = $nsid . '-mobile';
				$tabs[$id] = [] + $attribs;
				$tabs[$id]['title'] = $attribs['text'];
				$tabs[$id]['id'] = $id;
			}

			if ( !$title->isSpecialPage() ) {
				$tabs['more'] = [
					'text' => $skin->msg( 'monolith-more-actions' )->text(),
					'href' => '#p-cactions',
					'id' => 'ca-more'
				];
			}

			$tabs['toolbox'] = [
				'text' => $skin->msg( 'toolbox' )->text(),
				'href' => '#p-tb',
				'id' => 'ca-tools',
				'title' => $skin->msg( 'toolbox' )->text()
			];

			$languages = $skin->getLanguages();
			if ( count( $languages ) > 0 ) {
				$tabs['languages'] = [
					'text' => $skin->msg( 'otherlanguages' )->text(),
					'href' => '#p-lang',
					'id' => 'ca-languages',
					'title' => $skin->msg( 'otherlanguages' )->text()
				];
			}

			$content_navigation['cactions-mobile'] = $tabs;
		}
	}
}
