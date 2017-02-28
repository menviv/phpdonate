<?php
class PagesController extends AppController{
	var $name = 'Pages';
	var $components = array("Session","Mail");
	var $uses = array("Page","Article","Globalvar","Menu","News","Pages_param","Question","Answer","Event","Gallery","Staff","Box","Emailslayout","Survey","Surveyanswer","Portalitem","Item","Mainitem","Drug","Pagegallery");
	function beforeFilter(){
		parent::beforeFilter();
		$this->set("title_for_layout","הוועד למלחמה באיידס");
		$this->breadcrumbs[0]['name'] = "עמוד הבית";
		$this->breadcrumbs[0]['link'] = "";
		$excludeAction = array("index","rss","sendSurvey","fixLinks");
		if(!in_array($this->params['action'],$excludeAction)){
			if(isset($this->params['url']['url']) and !empty($this->params['url']['url'])){
				$this->currentUrl = $this->params['url']['url'];
				$this->set("currentUrl",$this->currentUrl);
				$this->managePages($this->currentUrl);
			}
		}
	}
	function beforeRender(){
		if(isset($this->currentPage)){
			$this->breadcrumbs[] = array("name"=>$this->currentPage['Page']['pname'],"link"=>$this->currentPage['Page']['link']);
			if($this->params['action']=="index")
				$this->set("breadcrumbs",array());
			else
				$this->set("breadcrumbs",$this->breadcrumbs);

			if(empty($this->currentPage['Page']['meta_title'])){
				$this->set("title_for_layout","");
			}
			else
				$this->set("title_for_layout",$this->currentPage['Page']['meta_title']);
			if(empty($this->currentPage['Page']['meta_keywords'])){
				//$this->set("meta_keywords",$this->Page->getValue("Page",1,"meta_keywords"));
				$this->set("meta_keywords","");
			}
			else
				$this->set("meta_keywords",$this->currentPage['Page']['meta_keywords']);
			if(empty($this->currentPage['Page']['meta_description'])){
				//$this->set("meta_description",$this->Page->getValue("Page",1,"meta_description"));
				$this->set("meta_description","");
			}
			else
				$this->set("meta_description",$this->currentPage['Page']['meta_description']);
		}
	}
	function index(){
		$this->getPage("");
		$boxItems = $this->Box->find("all",array("conditions"=>"type='homebottom'","order"=>"position asc","limit"=>"3"));
		$this->set("boxItems",$boxItems);
		$galleryImages = $this->Gallery->find("all",array("conditions"=>"type='home'","order"=>"position asc","limit"=>"5"));
		$this->set("galleryImages",$galleryImages);
		$news = $this->News->getNews(2,1);
		$this->set("news",$news);
		$survey = $this->Survey->find("","","dateAdd");
		$this->set("survey",$survey);
		$this->getSurveyAnswer("");
	}
	function contact(){
		$this->getRightMenu();
		$contactSubject = $this->Emailslayout->find("list",array("fields"=>array('id','subjectasso')));
		$this->set("contactSubject",$contactSubject);
		if(isset($this->data['contact']) and $this->checkAjaxFromOwnDomain()){
			$newData = $this->data['contact'];
			$require = array("email","subject","firstname");
			if(!$this->checkIfIsset($newData,$require) or !$this->checkIfNotEmpty($newData,$require)){
				echo "Empty";
				die();
			}
			if(!is_numeric($newData['subject'])){
				die();
			}
			$data = $this->validCleanVar($newData,"return");
			if(!empty($data['email']) and !$this->Mail->valid_email($data['email'])){
				echo "Error Email";
				die();
			}
			if(!$emailDetailsFound = $this->Emailslayout->find("id='".$newData['subject']."'")){
				echo "Error";
				die();
			}
			$emailDetails = $emailDetailsFound['Emailslayout'];
			//$emailDetails = $this->Emailslayout->getDetails("userContact");
			$emailText = $this->Emailslayout->replaceById($emailDetails['id'],array("%name%"=>$newData['firstname']." ".$newData['lastname'],"%phone%"=>$newData['phone'],"%cell%"=>$newData['cell'],"%subject%"=>$contactSubject[$newData['subject']],"%email%"=>$newData['email'],"%text%"=>$newData['text']));
			$emailText = "<div style='text-align:right;direction:rtl;'>".$emailText."</div>";
			$this->Mail->sendMail($emailDetails['subject'],$emailText,$emailDetails['receiver'],$emailDetails['sender']);
			echo "Fine";
			die();
		}
	}
	function faq(){
		$this->getRightMenu();
		$this->Question->bindParams("hasMany","Answer","Answer","","position asc","","question_id");
		$questions = $this->Question->find("all",array("order"=>"position asc","conditions"=>"page_id='".$this->currentPage['Page']['id']."'"));
		$this->set("questions",$questions);
		echo $this->render("faq");
		die();
	}
	function drugs(){
		$this->getRightMenu();
		$this->Drug->bindParams("hasMany","Inner","Drug","","position asc","","parent");
		$drugs = $this->Drug->find("all",array("order"=>"position asc","conditions"=>"parent='0'","fields"=>"name,id"));
		$this->set("drugs",$drugs);
		if(isset($_GET['open']) and is_numeric($_GET['open'])){
			$open = $_GET['open'];
			if($drugFound = $this->Drug->find("id='".$_GET['open']."'","id,parent")){
				if($drugFound['Drug']['parent'] != 0)
					$this->set("drugFound",$drugFound);
			}
		}
		echo $this->render("drugs");
		die();
	}
	function event(){
		$this->getRightMenu();
		$eventsLink = $this->getBreadCrumbs("events");
		$this->set("eventsLink",$eventsLink['Page']['link']);
		$event = $this->Event->find("page_id='".$this->currentPage['Page']['id']."'");
		$this->set("event",$event);
		$gallery = $this->Gallery->find("all",array("conditions"=>"type='event' and type_id='".$event['Event']['id']."'"));
		$this->set("galleryImages",$gallery);
		echo $this->render("event");
		die();
	}
	function events(){
		$this->getRightMenu();
		if(isset($_GET['archive']) and $_GET['archive']=="true"){
			$notArchive = date("Y-m-d",strtotime("-2 days"))." 00:00:00";
			$cond = "dateEvent<'$notArchive'";
			$order = "dateEvent desc";
			$this->set("archive","true");
		}else{
			$notArchive = date("Y-m-d",strtotime("-2 days"))." 00:00:00";
			$cond = "dateEvent>='$notArchive'";
			$order = "dateEvent asc";
		}
		$events = $this->Event->find("all",array("conditions"=>$cond,"order"=>$order,"fields"=>"name,excerpt,image,dateEvent,link"));
		$this->set("events",$events);
		echo $this->render("events");
		die();
	}
	function article(){
		$this->getRightMenu();
		$page_id = $this->currentPage['Page']['id'];
		if($article = $this->Article->find("page_id='$page_id'")){
			//$this->getBreadCrumbs("articlemain");
			//$this->currentPage['Page']['meta_title'] = $article['Article']['name'];
			//$this->breadcrumbs[] = array("name"=>$this->currentPage['Page']['pname'],"link"=>$this->currentPage['Page']['link']);
			if($article['Article']['related']!=0){
				$related = $this->Article->findById($article['Article']['related']);
				$this->set("related",$related);
				$relatedText = $this->render("../elements/related","emptyLayout");
				unset($this->breadcrumbs[sizeof($this->breadcrumbs)-1]);
				$article['Article']['content'] = str_replace("%relatedArticle%",$relatedText,$article['Article']['content']);
			}
			$this->output = "";
			$this->set("article",$article);
			echo $this->render("article");
			die();
		}
		else{
			$this->redirect("/");
			die();
		}
	}
	function mainarticle(){
		$this->getBoxesByPageId($this->currentPage['Page']['id']);
		$parent_id = $this->currentPage['Page']['parent'];
		if(!empty($parent_id) and $parent_id>0){
			$rightMenu = $this->Menu->getMenu("category",array("page_connected_id"=>$this->currentPage['Page']['parent']));
		}else
			$rightMenu = $this->Menu->getMenu("category",array("page_connected_id"=>$this->currentPage['Page']['id']));
		$this->set("rightMenu",$rightMenu);
		$portal = $this->Portalitem->find("all",array("conditions"=>"page_id='".$this->currentPage['Page']['id']."'","order"=>"position asc"));
		$this->set("portal",$portal);
		echo $this->render("mainarticle");
		die();
	}
	function mainitems(){
		$this->getRightMenu();
		$rightItems = $this->Mainitem->find("all",array("conditions"=>"page_id='".$this->currentPage['Page']['id']."' and type='right'","order"=>"position asc"));
		$leftItems = $this->Mainitem->find("all",array("conditions"=>"page_id='".$this->currentPage['Page']['id']."' and type='left'","order"=>"position asc"));
		$this->set("rightItems",$rightItems);
		$this->set("leftItems",$leftItems);
		echo $this->render("mainitems");
		die();
	}
	function staff(){
		$this->getRightMenu();
		$staff = $this->Staff->find("all",array("order"=>"position asc"));
		$this->set("staff",$staff);
		echo $this->render("staff");
		die();
	}
	function news(){
		$this->getRightMenu();
		$limit = 10;
		$page = (isset($_GET['page']) and is_numeric($_GET['page'])) ? $_GET['page'] : 1;
		$news = $this->News->find("all",array("order"=>"dateNews desc","limit"=>$limit,"page"=>$page));
		$count = $this->News->find("count");
		$rows = ceil($count/$limit);
		$this->set("rows",$rows);
		$this->set("count",$count);
		$this->set("current",$page);
		$this->set("page","/".$this->currentPage['Page']['link']);

		$this->set("news",$news);
		echo $this->render("news");
		die();
	}
	function search(){
		$text = (isset($_GET['search']) and !empty($_GET['search'])) ? $_GET['search'] : "";
		if(empty($text)){
			$this->redirect("/");
			die();
		}
		$currentPage = (isset($_GET['page']) and is_numeric($_GET['page'])) ? $_GET['page'] : 1;
		$result = $this->Page->find("all",array("conditions"=>"pname like '%$text%' or content like '%$text%'","limit"=>"10","page"=>$currentPage));
		$count = $this->Page->find("count",array("conditions"=>"pname like '%$text%' or content like '%$text%'"));
		$rows = ceil($count/10);
		$this->set("result",$result);
		$this->set("rows",$rows);
		$this->set("count",$count);
		$this->set("current",$currentPage);
		$this->set("page","/search?search=$text");
		$this->set("search","true");
		$this->set("searchText",$text);
		echo $this->render("search");
		die();
	}
	function donate(){
		$this->getRightMenu();
		if($this->currentPage['Page']['lang']=="en"){
			echo $this->render("donateen");
		}else{
			echo $this->render("donate");
		}
		die();
	}
	function donate2(){
		die();
		$this->getRightMenu();
		echo $this->render("donate2");
		die();
	}
	function rock(){
		echo $this->render("rock","rock");
		die();
	}
	function getBoxesByPageId($page_id){
		$boxCats = $this->Box->find("all",array("conditions"=>"type='category' and type_id='$page_id'","order"=>"position asc","limit"=>"3"));
		$this->set("boxCats",$boxCats);
	}
	public function sendSurvey(){
		if(isset($this->data['survey']['key']) and !empty($this->data['survey']['key'])){
			$id = $this->Survey->find("","id","dateAdd desc");
			$oldSession = $this->Session->read('Survey');
			if(isset($oldSession['Survey']['survey_id']) and !empty($oldSession['Survey']['survey_id'])){
				if($oldSession['Survey']['survey_id']==$id['Survey']['id'])
					$this->getSurveyAnswer("vote");
				if($data=$this->Surveyanswer->find("ip='".$_SERVER['REMOTE_ADDR']."' and survey_id = '".$id['Survey']['id']."' and session_id = '".$oldSession['Survey']['session_id']."'"))
					$this->getSurveyAnswer("vote");
			}
			if($data=$this->Surveyanswer->find("ip='".$_SERVER['REMOTE_ADDR']."' and survey_id = '".$id['Survey']['id']."'"))
				$this->getSurveyAnswer("vote");
			$newData['survey_id']=$id['Survey']['id'];
			$newData['answer']=$this->data['survey']['key'];
			$newData['ip']=$_SERVER['REMOTE_ADDR'];
			$newData['session_id']=$this->generateCode("15","Surveyanswer","session_id");
			$this->Surveyanswer->save($newData);
			$this->Session->delete('Survey');
    		$this->Session->write('Survey', $newData);
		}
		$this->getSurveyAnswer("vote");
	}
	public function getSurveyAnswer($from){
		$survey = $this->Survey->getLastSurvey();
		$id = $survey['Survey']['id'];
		if($data = $this->Surveyanswer->find("ip='".$_SERVER['REMOTE_ADDR']."' and survey_id = '$id'","id")){
			$this->Session->write('Survey',"true");
			$this->set("surveyAnswer","true");
		}
		$all = $this->Surveyanswer->find("count",array("conditions"=>"survey_id='$id'"));
		$answers[1] = $this->Surveyanswer->find("count",array("conditions"=>"survey_id='$id' and answer='1'"));
		$answers[2] = $this->Surveyanswer->find("count",array("conditions"=>"survey_id='$id' and answer='2'"));
		$answers[3] = $this->Surveyanswer->find("count",array("conditions"=>"survey_id='$id' and answer='3'"));
		$answers[4] = $this->Surveyanswer->find("count",array("conditions"=>"survey_id='$id' and answer='4'"));
		for($i=0;$i<4;$i++){
			if($all!=0)
				$answers[$i+1]=intval($answers[$i+1]/$all*100);
			else
				$answers[$i+1]=0;
		}
		$this->set("answers",$answers);
		$this->set("survey",$survey);
		if($from=="vote"){
			echo $this->render("../elements/surveyresult","emptyLayout");
			die();
		}
	}
	function gallery(){
		$this->getRightMenu();
		$galleries = $this->Pagegallery->find("all",array("conditions"=>"pageconnectedid='".$this->currentPage['Page']['id']."'","order"=>"position asc"));
		$this->set("galleries",$galleries);
		echo $this->render("gallery");
		die();
	}
	function galleryinner(){
		$this->getRightMenu();
		if(!$currentGallery = $this->Pagegallery->find("page_id='".$this->currentPage['Page']['id']."'")){
			$this->redirect("/");
			die();
		}
		$this->getBreadCrumbsById($currentGallery['Pagegallery']['pageconnectedid']);
		$mainPageLink = "/".$this->Page->getValue("Page",$currentGallery['Pagegallery']['pageconnectedid'],"link");
		$this->set("mainGallLink",$mainPageLink);
		$currentPage = (isset($_GET['page']) and is_numeric($_GET['page'])) ? $_GET['page'] : 1;
		$cond = "parent='".$currentGallery['Pagegallery']['id']."'";
		$result = $this->Pagegallery->find("all",array("conditions"=>$cond,"order"=>"position asc"));
		$count = $this->Pagegallery->find("count",array("conditions"=>$cond));
		$rows = 1;
		$this->set("images",$result);
		$this->set("rows",$rows);
		$this->set("count",$count);
		$this->set("current",$currentPage);
		$this->set("page","/".$this->currentPage['Page']['link']);
		echo $this->render("galleryinner");
		die();
	}

	function managePages($link){
		$this->getPage($link);
		$type = $this->currentPage['Page']['type'];
		$this->$type();
	}
	function getBreadCrumbs($page_type){
		if($find = $this->Page->find("type='$page_type'","pname,link"))
			$this->breadcrumbs[] = array("name"=>$find['Page']['pname'],"link"=>$find['Page']['link']);
		return $find;
	}
	function getBreadCrumbsById($page_id){
		if($find = $this->Page->find("id='$page_id'","pname,link"))
			$this->breadcrumbs[] = array("name"=>$find['Page']['pname'],"link"=>$find['Page']['link']);
		return $find;
	}
	function getArticleBreadCrumbsById($page_id){
		if($find = $this->Menu->find("page_id='$page_id' and type='category'","parent_id")){
			$parent = $find['Menu']['parent_id'];
			if(is_numeric($parent) and $parentMenu = $this->Menu->find("id=$parent")){
				$this->breadcrumbs[] = array("name"=>$parentMenu['Menu']['name'],"link"=>$parentMenu['Menu']['link']);
			}
		}
		return $find;
	}
	function getPage($link){
		$this->setRedirectPerma($link);
		if($this->currentPage=$this->Page->getPageByLink($link)){
			if($this->currentPage['Page']['lang']=="en"){
				$this->breadcrumbs[0]['name'] = "Home";
			}
			$header = $this->Menu->getMenu("header");
			$counter = 0;
			foreach($header as $linkItem):
				//$related = $this->Menu->find("all",array("conditions"=>"page_connected_id='".$linkItem['Menu']['page_id']."' and page_id!=''","fields"=>"id,name,link,parent_id","order"=>"id asc","group"=>"parent_id"));
				$rightMenu = $this->Menu->getMenu("category",array("page_connected_id"=>$linkItem['Menu']['page_id'],"inner"=>false,"fields"=>"id,name,link"));
				$header[$counter]['Related'] = $rightMenu;
				$counter++;
			endforeach;
			$this->set("headerLinks",$header);

			$catlist = $this->Menu->find("list",array('fields' =>"id,name","conditions"=>"type='category' and parent_id Is Null and page_id Is Null"));
			$this->set("catlist",$catlist);

			if($this->currentPage['Page']['lang']=="en"){
				$footer = $this->Menu->getMenu("footer",array("lang"=>"en"));
				$this->set("footerLinks",$footer);
			}

			//echo $this->currentPage['Page']['link'];
			$menuParentId = $this->Menu->getParentIdOfMenuLink("/".$this->currentPage['Page']['link']);
			$this->set("menuParentId",$menuParentId['parent_id']);
			$this->set("menuParentIdAll",$menuParentId);

			if($menuParentId==0 and $this->currentPage['Page']['parent']>0 and $this->currentPage['Page']['parent']<7){
				$this->set("headerConnected",$this->currentPage['Page']['parent']-1);
			}else{
				$headerConnected = $this->Menu->getMenuHeaderSel($menuParentId['page_connected_id']);
				$this->set("headerConnected",$headerConnected);
			}
			$this->set("contact_us_number",$this->Globalvar->getSetting("%contact_us_number%"));
			if(!in_array($this->currentPage['Page']['type'],array("aboutitem","about"))){
				if(empty($this->currentPage['Pages_param']['bottom_title']) or empty($this->currentPage['Pages_param']['bottom_text'])){
					if(empty($this->currentPage['Pages_param']['bottom_title']))
						$this->currentPage['Pages_param']['bottom_title'] = $this->Globalvar->getSetting("%bottom_title%");//$page['Pages_param']['bottom_title'];
					if(empty($this->currentPage['Pages_param']['bottom_text']))
						$this->currentPage['Pages_param']['bottom_text'] = $this->Globalvar->getSetting("%bottom_text%");//$page['Pages_param']['bottom_title'];
				}
			}
			$this->set("currentPageData",$this->currentPage);
		}
		else{
			/** The current link is not found in the db **/
			$this->redirect("/");
			die();
			return false;
		}
	}
	function setRedirectPerma($currentLink=""){
		$links = array();
		$links['zope/categories/prevention'] = "/qwe";
		$links['zope/categories/news'] = "/news";
		$links['zope/categories/treatment'] = "/hiv/begin_treatment";
		$links['zope/home/testing_across_israel/'] = "/info/testing_across_israel";
		if(isset($links[$currentLink])){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".$links[$currentLink]);
			die();
		}
	}
	function getRightMenu(){
		if($this->currentPage['Page']['type']=="event")
			$this->currentPage['Page']['parent'] = 6;
		$parent_id = $this->currentPage['Page']['parent'];
		$addIds = array();
		if(empty($parent_id) or $parent_id<=0){
			$parent_id = $this->currentPage['Page']['id'];
			$addIds[] = $parent_id;
		}
		else{
			while($parent_id>0){
				$newparent_id = $this->Page->getValue("Page",$parent_id,"parent");
				if($newparent_id>0){
					$addIds[] = $newparent_id;
					$parent_id = $newparent_id;
				}else{
					break;
				}
			}
		}
		$this->getBoxesByPageId($parent_id);
		if(!in_array($this->currentPage['Page']['parent'],$addIds))
			$addIds[] = $this->currentPage['Page']['parent'];
		if($this->currentPage['Page']['type']!="galleryinner"){
			foreach($addIds as $ids):
				$this->getBreadCrumbsById($ids);
			endforeach;
		}
		$this->getArticleBreadCrumbsById($this->currentPage['Page']['id']);
		$rightMenu = $this->Menu->getMenu("category",array("page_connected_id"=>$parent_id));
		if($_SERVER['REMOTE_ADDR']=="82.80.139.192"){
		//print_r($rightMenu);
		//die();
		}
		$this->set("rightMenu",$rightMenu);
	}
	function fixLinks(){
		die();
	}
	function redit(){
		$this->currentPage['Page']['parent'] = 4;
		$this->getRightMenu();
		echo $this->render("redit");
		die();
	}
}
?>