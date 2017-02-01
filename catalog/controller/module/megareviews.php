<?php
class ControllerModuleMegareviews extends Controller {
	public function index($setting) {
	    
		$data = $this->load->language('module/megareviews');
		$this->load->model('module/megareviews');
		$settings=$this->config->get('megareviews_settings');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['options'] = $this->model_module_megareviews->getOptions();
		$data['ays'] = $this->model_module_megareviews->getAys();
		$data['addLink']=$this->url->link( "module/megareviews/addReview",'','SSL');
                
        $link=Array("module/megareviews/ajaxOptions"=>$this->url->link( "module/megareviews/ajaxOptions",'','SSL' ),"module/megareviews/ajaxAddReview"=>$this->url->link( "module/megareviews/ajaxAddReview",'','SSL' ),"module/megareviews/ajaxgetReviews"=>$this->url->link( "module/megareviews/ajaxgetReviews" ,'','SSL'),"module/megareviews/ajaxValidate"=>$this->url->link( "module/megareviews/ajaxValidate",'','SSL' ),"module/megareviews/ajaxVote"=>$this->url->link( "module/megareviews/ajaxVote",'','SSL' ));
		$data['link']=$link;
		if (isset($this->request->get['product_id'])) 
            $data['product_id'] = $this->request->get['product_id'];
		$data['reviewsinfo'] = $this->model_module_megareviews->getReviewsInfo($data['product_id']);
		$data['settings']=$this->config->get('megareviews_settings');
		$filter_data = array(
			'product_id' => $data['product_id'],
			'sort'  => 'r.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $settings['perpage']
		);
		
		
		$css_file = 'megareviews.css';
		if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/' . $css_file)) {
        	$data['path']='catalog/view/theme/' . $this->config->get('config_template');	
        	$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template'). '/stylesheet/' . $css_file);
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template'). '/stylesheet/magnific-popup.css');
    	}else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/' . $css_file);
			$this->document->addStyle('catalog/view/theme/default/stylesheet/magnific-popup.css');
    		$data['path']='catalog/view/theme/default';
		}
		$this->document->addStyle('https://code.jquery.com/ui/1.8.23/themes/smoothness/jquery-ui.css');
		$this->document->addStyle('https://fonts.googleapis.com/css?family=Open+Sans');
        
       
    	$this->document->addScript('catalog/view/javascript/jquery-ui.min.js');
		$this->document->addScript('catalog/view/javascript/megareviews.js');
		$this->document->addScript('catalog/view/javascript/jquery.magnific-popup.min.js');
		$this->load->model('tool/image');
		$data['reviewsinfo']['stars']='';
		$rating=$data['reviewsinfo']['rating'];$starwidth=20;
			for($i=1;$i<=5;$i++){
				if($i<=$rating)
					$data['reviewsinfo']['stars'].="<div class='mr-star'><img width='".$starwidth."' src='".$data['path']."/image/mr/full-star.png'/></div>";
				else {
					$data['reviewsinfo']['stars'].="<div class='mr-star'><img width='".$starwidth."' src='".$data['path']."/image/mr/empty-star.png'/></div>";
				}
			}
			if(floor($rating)!=$rating){
				$pos=floor($rating)*$starwidth;
				$width=($rating-floor($rating))*$starwidth;
				$data['reviewsinfo']['stars'].="<div class='mr-star' style='position:absolute;left:".$pos."px;overflow:hidden;width:".$width."px;'><img width='".$starwidth."' height='".$starwidth."' src='".$data['path']."/image/mr/full-star.png'/></div>";
			}
		
		$data['reviews'] = $this->model_module_megareviews->getReviews($filter_data);
		if(isset($_COOKIE['lastvote'])){
			$lastvote=html_entity_decode($_COOKIE['lastvote']);
			$votes=json_decode(($lastvote),true); 
		}
		foreach($data['reviews'] as &$review){
			$stars='';
			$starwidth=15;
			for($i=1;$i<=5;$i++){
				if($i<=$review['rating'])
					$stars.="<div class='mr-star'><img width='".$starwidth."' src='".$data['path']."/image/mr/full-star.png'/></div>";
				else {
					$stars.="<div class='mr-star'><img width='".$starwidth."' src='".$data['path']."/image/mr/empty-star.png'/></div>";
				}
			}
			$review['stars']=$stars;
			$review['options']=$this->model_module_megareviews->getOptionValues($review['review_id']);
			$review['ays']=$this->model_module_megareviews->getAyValues($review['review_id']);
			$review['images']=$this->model_module_megareviews->getImages($review['review_id']);
			foreach($review['images'] as &$im){
				$im['small'] = $this->model_tool_image->resize($im['big'], 100, 100);
			}
			unset($im); 
			if(isset($votes[$review['review_id']]))$review['vote']=$votes[$review['review_id']]; else $review['vote']=-1;
		}
		unset($review);
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/megareviews.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/megareviews.tpl', $data);
        } else {
            return $this->load->view('default/template/module/megareviews.tpl', $data);
        }
        
	}
	public function addReview(){
		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
			$post=$this->request->post;
			$this->load->model('setting/setting');
			$settings=$this->config->get('megareviews_settings');
			if ($settings['captcha']==1 && (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha']))) {
                return;
            }
			for ($i = 0; $i < count($_FILES['file']['name']); $i++) {//loop to get individual element from the array
				$target_path = "image/catalog/mr/"; //Declaring Path for uploaded images
		    	if(!is_dir($target_path)) mkdir($target_path);
		        $validextensions = array("jpeg", "jpg", "png");  //Extensions which are allowed
		        $ext = explode('.', basename($_FILES['file']['name'][$i]));//explode file name from dot(.) 
		        $file_extension = end($ext); //store extensions in the variable
		        
				$target_name = rand(1,10000). $ext[0]. "." . $ext[count($ext) - 1];//set the target path with a new name of image
		        $target_path = $target_path.$target_name;
		        $j = $j + 1;//increment the number of uploaded images according to the files in array       
		      	
			  if (($_FILES["file"]["size"][$i] < 10000000) //Approx. 100kb files can be uploaded.
		                && in_array($file_extension, $validextensions)) {
		            if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {//if file moved to uploads folder
		                $post['files'][]="catalog/mr/".$target_name;
		            } else {//if file was not moved.
		                
		            }
		        } 
		    }
	    }
		$post['status']='0';
		if($settings['approve']==0)$post['status']='1';
		$this->load->model('module/megareviews');
		
		$this->model_module_megareviews->addReview($post);
	}
	public function ajaxOptions() {
		$this->load->model('module/megareviews');	
		$this->load->model('setting/setting');
		$s=$this->config->get('megareviews_settings');
		echo json_encode(Array("options" => $this->model_module_megareviews->getOptions(), "ay" => $this->model_module_megareviews->getAys(), "rating" => $s["rvalues"]));
	}
	public function ajaxVote() {
		$this->load->model('module/megareviews');	
		$this->load->model('setting/setting');
		$filter_data=$_POST;
		$forever = time()+3600*24*365*10;
		if(isset($_COOKIE['lastvote'])){
		    $lastvote=html_entity_decode($_COOKIE['lastvote']);		
		      $votes=json_decode(($lastvote),true); 
        }
		//print_r($votes);
		if(isset($votes[$filter_data['id']])){
			if($votes[$filter_data['id']]==$filter_data['vote']){
				unset($votes[$filter_data['id']]);
				$result['status']=0;
				if($filter_data['vote']==0) $this->model_module_megareviews->downVote($filter_data['id'],-1); else $this->model_module_megareviews->upVote($filter_data['id'],-1);
			}else{
				$result['status']=-1;
			}
		}else{
			$result['status']=1;
			$votes[$filter_data['id']]=$filter_data['vote'];
			if($filter_data['vote']==0) $this->model_module_megareviews->downVote($filter_data['id'],1); else $this->model_module_megareviews->upVote($filter_data['id'],1);
		}
		
		setcookie( 'lastvote', json_encode($votes), $forever); 
		//print_r($_COOKIE);
		echo json_encode($result);
	}
	public function ajaxValidate() {
		$filter_data=$_POST;
		$this->load->model('setting/setting');
		$settings=$this->config->get('megareviews_settings');
		$this->load->language('module/megareviews');
		$f=true;
        $error=null;
		if($settings['recommend']==2 && !isset($filter_data['recommend'])){
			$f=false;
			$error["recommend"]=$this->language->get('text_requirederror');
		}
		if($settings['rating']==2 && $filter_data['rating']<0){
			$f=false;
			$error["rating"]=$this->language->get('text_requirederror');
		}
		if($settings['title']==2 && strlen($filter_data['title'])==0){
			$f=false;
			$error["title"]=$this->language->get('text_requirederror');
		}
		if($settings['text']==2 && strlen($filter_data['text'])==0){
			$f=false;
			$error["text"]=$this->language->get('text_requirederror');
		}
		if(strlen($filter_data['text'])<$settings['textcount']){
			$f=false;
			$error["text"].=$this->language->get('text_lengtherror');
		}
		if($settings['nickname']==2 && strlen($filter_data['author'])==0){
			$f=false;
			$error["author"]=$this->language->get('text_requirederror');
		}
		if ($settings['captcha']==1 && (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $filter_data['captcha']))) {
            $f=false;
            $error['captcha'] = $this->language->get('text_errorcaptcha');
        }
			$result["status"] = $f ? '1' : '0';
			$result["message"]=$f ? $settings['approve']==1 ? $this->language->get('text_addsuccess0') : $this->language->get('text_addsuccess1') : $this->language->get('text_adderror');
			$result["error"]=$error;
		echo json_encode($result);
	}
	public function ajaxgetReviews() {
		$filter_data=$_POST;
		
		$data = $this->load->language('module/megareviews');
		$this->load->model('module/megareviews');
		$settings=$this->config->get('megareviews_settings');
		$data['options'] = $this->model_module_megareviews->getOptions();
		$data['ays'] = $this->model_module_megareviews->getAys();
		
		
        $data['product_id'] = $filter_data['product_id'];
		$data['reviewsinfo'] = $this->model_module_megareviews->getReviewsInfo($data['product_id']);
		$data['settings']=$this->config->get('megareviews_settings');
		$filter_data = array(
			'product_id' => $data['product_id'],
			'sort'  => $filter_data['sort'],
			'order' => $filter_data['order'],
			'start' => (int) $filter_data['start'],
			'limit' => (int)$filter_data['limit']
		);
		
		
		$css_file = 'megareviews.css';
		if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/' . $css_file)) {
        	$data['path']='catalog/view/theme/' . $this->config->get('config_template');	
        }else {
			$data['path']='catalog/view/theme/default';
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/megareviews_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/megareviews_list.tpl';
		} else {
			$this->template = 'default/template/module/megareviews_list.tpl';
		}
		
		$this->load->model('tool/image');
		
		$rating=$data['reviewsinfo']['rating'];$starwidth=25;
        $data['reviewsinfo']['stars']='';
			for($i=1;$i<=5;$i++){
				if($i<=$rating)
					$data['reviewsinfo']['stars'].="<div class='mr-star'><img width='".$starwidth."' src='".$data['path']."/image/mr/full-star.png'/></div>";
				else {
					$data['reviewsinfo']['stars'].="<div class='mr-star'><img width='".$starwidth."' src='".$data['path']."/image/mr/empty-star.png'/></div>";
				}
			}
			if(floor($rating)!=$rating){
				$pos=floor($rating)*$starwidth;
				$width=($rating-floor($rating))*$starwidth;
				$data['reviewsinfo']['stars'].="<div class='mr-star' style='position:absolute;left:".$pos."px;overflow:hidden;width:".$width."px;'><img width='".$starwidth."' height='".$starwidth."' src='".$data['path']."/image/mr/full-star.png'/></div>";
			}
		
		$data['reviews'] = $this->model_module_megareviews->getReviews($filter_data);
		if(isset($_COOKIE['lastvote'])){
			$lastvote=html_entity_decode($_COOKIE['lastvote']);
			$votes=json_decode(($lastvote),true); 
		}
		
		foreach($data['reviews'] as &$review){
			$stars='';
			$starwidth=15;
			for($i=1;$i<=5;$i++){
				if($i<=$review['rating'])
					$stars.="<div class='mr-star'><img width='".$starwidth."' src='".$data['path']."/image/mr/full-star.png'/></div>";
				else {
					$stars.="<div class='mr-star'><img width='".$starwidth."' src='".$data['path']."/image/mr/empty-star.png'/></div>";
				}
			}
			$review['stars']=$stars;
			$review['options']=$this->model_module_megareviews->getOptionValues($review['review_id']);
			$review['ays']=$this->model_module_megareviews->getAyValues($review['review_id']);
			$review['images']=$this->model_module_megareviews->getImages($review['review_id']);
			foreach($review['images'] as &$im){
				$im['small'] = $this->model_tool_image->resize($im['big'], 100, 100);
			}
			unset($im); 
			if(isset($votes[$review['review_id']]))$review['vote']=$votes[$review['review_id']]; else $review['vote']=-1;
		}
		unset($review);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/megareviews_list.tpl')) {
            print_r( $this->load->view($this->config->get('config_template') . '/template/module/megareviews_list.tpl', $data));
        } else {
            print_r($this->load->view('default/template/module/megareviews_list.tpl', $data));
        }
		
	}
}
?>