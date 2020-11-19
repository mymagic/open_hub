<?php

class FrontendController extends Controller
{
	// customParse is for cpanelNavOrganizationInformation to pass in organization ID
	//public $customParse = '';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions' => array('index'),
				'users' => array('*'),
			),
			array(
				'allow',
				'actions' => array(),
				'users' => array('@'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->layout = 'frontend';
		//$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);

		// for cpanel navigation
		// $this->layout = 'layout.cpanel'; //default layout for cpanel
		// $this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		// $this->cpanelMenuInterface = 'cpanelNavDashboard'; //cpanel menu interface type ex. cpanelNavDashboard, cpanelNavSetting, cpanelNavOrganization, cpanelNavOrganizationInformation
		// $this->customParse = ''; //to pass in organization ID for cpanelNavOrganizationInformation
		// $this->activeMenuCpanel = ''; //active menu name based on NameModule.php getNavItems() active attribute

		if (!Yii::app()->getModule('cv')->isFrontendEnabled) {
			Notice::page(Yii::t('cv', 'This page has been disabled by admin'), Notice_INFO);
		}
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionPortfolio($slug)
	{
		$portfolio = CvPortfolio::slug2obj($slug);

		// visibility
		if ($portfolio->visibility == 'protected' && Yii::app()->user->isGuest) {
			Notice::page(Yii::t('app', 'This portfolio only open to registered user'), Notice_INFO);
		}

		if ($portfolio->visibility == 'private' && Yii::app()->user->id != $portfolio->member->user->id) {
			Notice::page(Yii::t('app', 'This is a private portfolio accessible by its owner only'), Notice_INFO);
		}

		$attendedPrograms = $portfolio->getAttendedPrograms();
		//print_r($attendedPrograms);exit;
		$items = $portfolio->getComposedExperiences();
		//echo "<pre>";print_r($programs);exit;
		$skillsets = $portfolio->getDistinctSkillset();
		sort($skillsets);
		//echo "<pre>";print_r($skillsets);exit;

		/*$contactForm = new ContactForm;
		$contactForm->name = "Your admire";

		if(isset($_POST['ContactForm']))
		{
			$contactForm->attributes=$_POST['ContactForm'];
			$contactForm->subject = sprintf("%s saw your MaGIC Profile and like to contact you!", $contactForm->email);

			//print_r($contactForm);exit;
			if($contactForm->validate())
			{
				// store to db for tracking
				$contactMe=new Contactme;
				$contactMe->portfolio_id = $portfolio->id;
				$contactMe->from_email = $contactForm->email;
				$contactMe->to_email = $portfolio->user->username;
				$contactMe->text_message = $contactForm->body;
				$contactMe->save();

				//echo "{$portfolio->user->username}, {$contactForm->subject}, {$contactForm->body}, {$contactForm->email}";exit;
				//  sendMail($receivers, $subject, $message, $replyTo)
				$receivers[] = array('email'=>$portfolio->user->username, 'name'=>$portfolio->display_name);
				$receivers[] = array('method'=>'reply', 'email'=>$contactForm->email, 'name'=>$contactForm->email);
				//$receivers[] = array('email'=>$contactForm->email, 'name'=>$contactForm->email, 'method'=>'reply');
				$result = ysUtil::sendMail(
					$receivers, $contactForm->subject,
					sprintf("<p>From: %s</p><br><p>Message:<br>%s</p>", $contactForm->email, $contactForm->body),
					'noreply@mymagic.my'
				);

				if($result === true)
				{
					Notice::page(
						Yii::t('app', 'Thank you for contacting {name}. He/She will respond to you as soon as possible.', array('{name}'=>$portfolio->display_name)),
						Notice_SUCCESS,
						array('url'=>Orang::getPortfolioUrl($portfolio))
					);
				}
				else
				{
					Notice::page(
						Yii::t('app', 'Thank you for contacting {name}. But we cant reach him/her at the moment. Please try again later.', array('{name}'=>$portfolio->display_name)),
						Notice_ERROR,
						array('url'=>Orang::getPortfolioUrl($portfolio))
					);
				}
			}
			else
			{
				//echo "not validate!";exit;
			}
		}*/

		// $this->render('portfolio', array('model' => $portfolio, 'items'=>$items, 'attendedPrograms'=>$attendedPrograms, 'skillsets'=>$skillsets,'contactForm'=>$contactForm));
		$this->render('portfolio', array('model' => $portfolio, 'items' => $items, 'attendedPrograms' => $attendedPrograms, 'skillsets' => $skillsets));
	}
}
