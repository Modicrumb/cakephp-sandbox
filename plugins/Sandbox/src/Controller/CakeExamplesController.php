<?php
namespace Sandbox\Controller;

use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class CakeExamplesController extends SandboxAppController {

	public $helpers = ['Markup.Highlighter'];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * CakeExamplesController::index()
	 *
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * CakeExamplesController::query_strings()
	 *
	 * @return void
	 */
	public function queryStrings() {
	}

	/**
	 * CakeExamplesController::merge()
	 *
	 * @return void
	 */
	public function merge() {
		$array = [
			'root' => [
				'deep1' => ['deeper1a' => 'value1a', 'deeper2b' => 'value2b'],
				'deep2' => ['deeper1', 'deeper2'],
				'deep3' => 'stringX',
			]
		];
		$mergeArray = [
			'root' => [
				'deep1' => ['deeper1a' => 'value1a', 'deeper3b' => 'value3b'],
				'deep2' => ['deeper1', 'deeper3'],
				'deep3' => 'stringY',
			]
		];

		if ($type = $this->request->query('type')) {
			switch ($type) {
				case 'hash':
					$result = Hash::merge($array, $mergeArray);
					break;
				case 'am':
					$result = am($array, $mergeArray);
					break;
				case 'array_merge':
					$result = array_merge($array, $mergeArray);
					break;
				case 'array_merge_recursive':
					$result = array_merge_recursive($array, $mergeArray);
					break;
				default:
					throw new NotFoundException('Invalid merge type');
			}
		}

		$this->set(compact('array', 'mergeArray', 'result'));
	}

	/**
	 * CakeExamplesController::i18n()
	 *
	 * @return void
	 */
	public function i18n() {
		// Make sure we have defaults set to I18n if language has been switched previously
		if ($lang = $this->Session->read('Config.language')) {
			I18n::locale($lang);
		} else {
			$this->Session->write('Config.language', 'en');
		}

		// Language switcher
		if ($this->request->is('post')) {
			$lang = $this->request->query('lang');
			$this->Session->write('Config.language', $lang);
			I18n::locale($lang);
			$lang = locale_get_display_name($lang) . ' [' . strtoupper($lang) . ']';
			$this->Flash->success(__('Language switched to {0}.', $lang));
			return $this->redirect(['action' => 'i18n']);
		}
	}

	/**
	 * Test validation on marshal and rules on save.
	 *
	 * @return void
	 */
	public function validation() {
		$Animals = TableRegistry::get('Sandbox.Animals');

		$animal = $Animals->newEntity();

		if ($this->request->is('post')) {
			$animal = $Animals->patchEntity($animal, $this->request->data);

			// Simulate $Animals->save($animal) call as we dont't want to really save here
			if (!$animal->errors() & $Animals->checkRules($animal)) {
				$this->Flash->success('Yeah, entry would have been saved.');
			} else {
				$this->Flash->error('Please correct your form content.');
			}
		}

		$this->set(compact('animal'));
	}

	/**
	 * //TODO
	 *
	 * @return void
	 */
	public function _translate_behavior() {
	}

}
