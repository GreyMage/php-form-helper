<?php

	class formGroup {
		var $label;
		var $cla;
		var $elements = array();
		
		function formGroup($label,$cla=false,$elements=array()){
			if(!$cla){
				$this->cla = trim(str_replace(" ","",strtolower($label)));
			} else {
				$this->cla = $cla;
			}
			$this->label = $label;
			$this->elements = $elements;
		}
		
		function add($element){
			$this->elements[] = $element;
		}
		
		function getHTML(){
			$ret = sprintf('<div class="formset %s"><div class="legend">%s</div>%s</div>',$this->cla,$this->label,$this->innerHTML());
			return $ret;
		}
		
		function innerHTML(){
			$ret="";
			// Get element HTML;
			if(!empty($this->elements)){
				foreach($this->elements as $elem){
					if(is_object($elem) && method_exists($elem,"getHTML")){
						$ret .= $elem->getHTML();
					} else {
						$ret .= $elem;
					}
				}
			}
			return $ret;
		}
		
	}
	
	class formElement {
		var $label; // the submitted label
		var $name; // the submitted name
		var $tag; // dom element. input, textarea, whatever
		var $attrs; // arbitrary attributes
		var $selfclose = true; // self close? (usually, but not for like, textarea.)
		
		function formElement($label="",$name=false,$attrs=array("type"=>"text"),$tag="input",$selfclose=true){
			if(empty($label)) throw new Exception("Must have element Label");
			if(!$name){
				$this->name = trim(str_replace(" ","",strtolower($label)));
			} else {
				$this->name = $name;
			}
			$this->id = "lbfor_".$name;
			$this->label = $label;
			$this->attrs = $attrs;
			$this->tag = $tag;
			$this->selfclose = $selfclose;
		}
		
		function getButton(){
			$ret = sprintf('<div class="container submit"><input type="submit" value="%s" /></div>',$this->label);
			return $ret;
		}
		
		function getHTML(){
			$ret = sprintf('<div class="container %s"><label for="lbfor_%s">%s</label>%s</div>',$this->name,$this->name,$this->label,$this->innerHTML());
			return $ret;
		}
		
		function innerHTML(){
			$ret = sprintf('<%s id="%s" name="%s"',$this->tag,$this->id,$this->name);
			if(!empty($this->attrs)){
				foreach($this->attrs as $k=>$v){
					$ret = sprintf('%s %s="%s"',$ret,$k,$v);
				}
			}
			if($this->selfclose){
				$ret = sprintf('%s />',$ret);
			} else {
				$ret = sprintf('%s></%s>',$ret,$this->name);
			}
			return $ret;
		}
	}
	
	class formBuilder {
		var $id = false;
		var $action = "";
		var $method = "post";
		var $elements = array();

		function formBuilder($action="",$method="post",$elements=array(),$id=false){
			$this->action = $action;
			$this->method = $method;
			$this->elements = $elements;
		}
		
		function add($elem){
			$this->elements[] = $elem;
		}
		
		function addAsButton($elem){
			$this->elements[] = $elem->getButton();
		}
			
		function getHTML(){
		
			// Start building form
			$ret = sprintf('<form action="%s" method="%s"',$this->action,$this->method);
			if($this->id){
				$ret = sprintf('%s id="%s"',$ret,$this->id);
			}
			$ret = sprintf('%s>',$ret);
			
			// Apply a honeypot value, if its no empty, then something is filling this out automatically, like a bot!
			$honeypot = new formElement("honeypot","honeypot",array(
				"type"=>"text",
				"style"=>"display:none"
			));
			$this->elements[] = $honeypot->innerHTML();
			
			// Get element HTML;
			if(!empty($this->elements)){
				foreach($this->elements as $elem){
					if(is_object($elem) && method_exists($elem,"getHTML")){
						$ret .= $elem->getHTML();
					} else {
						$ret .= $elem;
					}
				}
			}			
			
			// Finish up
			$ret = sprintf('%s</form>',$ret);
			return $ret;
		}
	}