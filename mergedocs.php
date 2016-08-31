<?php
echo "running";
//error_reporting(-1);

error_reporting(E_ALL);
ini_set("display_errors", 1); 
define('WP_USE_THEMES', false);
define('STYLESHEETPATH', '');
define('TEMPLATEPATH', '');
require "D:\\inetpub\\app\\wwwroot\\wp-blog-header.php";
//echo "running";

//define( 'SHORTINIT', true );
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
global $wpdb;
//checks for list of entries to generate docs;
$leads = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tpl_docs  WHERE cron_status = 0  " ,"")  );

if(!empty($leads)){
	echo "There are leads<br/> ";
	foreach($leads as $lead){
		$form = GFAPI::get_form( $lead->form_id);
		$entry = GFAPI::get_entry($lead->lead_id);
		//echo $form;
		cron_merge_template($form,$entry,$lead->file_id,$lead->invoice_number);
		

	}
}else{
	echo "No Leads To Generate Docs";
}

//Initialising document generation process and email trigger
function cron_merge_template($form,$entry,$fileid,$invoice_number=""){
	$return="";
    $formid  = $entry['form_id'];
    
    $where = 'form_id ='.$formid;
    $params = array('where'=>$where);

    $templates = gettplList($params);
    $fieldmap = gettplFieldMap($params);
    echo "LeadID : ".$entry['id']." msg: <br/>";//.print_r($templates['meta']['files'],true);
	 
    if(!empty($templates['meta']['files'])){
		//echo print_r($fileid, true);
        $return = cron_tpl_combine($entry,$templates,$fieldmap,$fileid);
		echo 'Return: '.$return;
    }else {
		echo 'empty';
	}
	
	$letters = "";
	$invoices = "";
    if($return !=""){
		 echo "Doc : ".$return."<br>";
        $letters = cron_LettersMerge($entry,$fieldmap);
        $invoices = cron_InvoicesMerge($entry,$fieldmap,$invoice_number);
        
        $doc_email_msg = TriggerDocumentEmail($entry['id']);
        
        if(!empty($doc_email_msg) && $doc_email_msg['status'] == "success"){
            
				$status = 1;
				$message = $doc_email_msg['msg'];
				cron_statusUpdate( $entry['id'],$status,$message);
			
        }else{
				$status = 2;
				$message = "Email Sent Failed";
				cron_statusUpdate( $entry['id'],$status,$message);
		}
        
    }else{
		$status = 2;
		$message = "Document generation Failed";
		cron_statusUpdate( $entry['id'],$status,$message);
	}
}

//returns tempalte files with logical conditions satisfied from backend
function cron_tpl_combine($entry,$templates,$mapfield,$fileid){
    
    $files = positionsort($templates['meta']['files']);
    $mfileurl = "";
    
    $proceed = 0;
    $tpls = array();
    $js = 0;
    
    foreach($files as $file){
        
        $tpl_values = array();
        
        if(!empty($file['filepath'])){
            $proceed = 1;
            $tpl_values = tpl_values_merge($entry,$mapfield);
            
            if($proceed == 1 && !empty($tpl_values)){
                 $tpls[] = array('file'=>$file,'values'=>$tpl_values);       
            }
           	$ofieldvalue = "";
            $ofieldvalue_e = "";
            $ofieldvalue_f = "";
            if(isset($entry[$file['form_field']])){
                $ofieldvalue = explode("|",$entry[$file['form_field']]);    
            }

            if(isset($entry[$file['form_field_e']])){
                $ofieldvalue_e = explode("|",$entry[$file['form_field_e']]);
            }
            if(isset($entry[$file['form_field_f']])){
                $ofieldvalue_f = explode("|",$entry[$file['form_field_f']]);
            }
            if(isset($entry[$file['form_field_g']])){
                $ofieldvalue_g = explode("|",$entry[$file['form_field_g']]);
            }
                   
            $remove = 0;
            
            
            if((!empty($file['form_field_e']) ||  !empty($file['form_field_f'])) && !empty($file['form_field'])){
            	if(!empty($file['operator_value']) && !empty($file['form_field'])  && $file['operator_value'] != $ofieldvalue[0]){
            	
		               $remove = 1;
		            
		        }else if(empty($file['operator_value']) && !empty($file['form_field']) && empty($entry[$file['form_field']])){
		        	
		                $remove = 1;
		            
		        }

		        if(!empty($file['operator_value_e']) && !empty($file['form_field_e']) && $file['operator_value_e'] != $ofieldvalue_e[0]){
		        	
		               $remove = 1;
		            
		        }else if(empty($file['operator_value_e']) && !empty($file['form_field_e']) && empty($entry[$file['form_field_e']])){
		      
		                $remove = 1;
		            
		        }

                if(!empty($file['operator_value_f']) && !empty($file['form_field_f']) && $file['operator_value_f'] != $ofieldvalue_f[0]){
               
                       $remove = 1;
                    
                }else if(empty($file['operator_value_f']) && !empty($file['form_field_f']) && empty($entry[$file['form_field_f']])){
                 
                        $remove = 1;
                    
                }
				
				if(!empty($file['operator_value_g']) && !empty($file['form_field_g']) && $file['operator_value_g'] != $ofieldvalue_g[0]){
               
                       $remove = 1;
                    
                }else if(empty($file['operator_value_g']) && !empty($file['form_field_g']) && empty($entry[$file['form_field_g']])){
            
                        $remove = 1;
                    
                }
		        
		        if($remove == 1){
		        	
		        	array_pop($tpls);
		        }
            	
            }else{
			        if(!empty($file['operator_value']) && !empty($file['form_field']) && $file['operator_value'] != $ofieldvalue[0]){
			        	
		               array_pop($tpls);
		            
		            }else if(empty($file['operator_value']) && !empty($file['form_field']) && empty($entry[$file['form_field']])){
		            	
		                array_pop($tpls);
		            
		            }

            }
    
           
 
        }
        $js++;
        
    }
    
  
    if(!empty($tpls)){
	
          $tpls = templatemergealgorithm($tpls,$entry['form_id']);
    
          $mfileurl=  cron_tpl_merge_process($tpls,$entry,"",$fileid);
              
    }    
    
    return $mfileurl;
}



//Document generation process
function cron_tpl_merge_process($tpls,$entry,$type="",$invoice_number=""){
	echo "inside merge process.<br/>";
    	
	require_once "D:\\inetpub\\app\\wwwroot\\wp-content\\plugins\\templatemerge\\phpdocx-v4\\classes\\TransformDocAdv.inc";
	require_once "D:\\inetpub\\app\\wwwroot\\wp-content\\plugins\\templatemerge\\phpdocx-v4\\classes\\CreateDocx.inc";
    
	$final_doc_url ="";
	$formdetail = RGFormsModel::get_form($entry["form_id"]);
	$new_xml = array();
	
		$unique_number = date('ymdhis')."-".$entry["id"];

	
	$n = str_replace('+','_',urlencode($formdetail->title)).($type !="" ? "_".$type :"")."_".$unique_number.'-cron.docx';
	
	if($type =="Invoice" && $invoice_number==""){
		$invoice_number = generate_invoice_number();
		
	}
	
	$i=1;
	
    foreach($tpls as $tpl){
		
		
        $file = $tpl['file'];
        $value = $tpl['values'];
		$value["Invoice_number"] = $invoice_number;
        
        if(!empty($file['dir_path']) && !empty($file['filepath'])){
            
            $cookie_file_path = $file['filepath'];
			/*echo '<br/>Cookie path: '.$cookie_file_path;
			if (!file_exists($cookie_file_path)) {
                echo 'file does not exist';
            }
            else {
            	echo 'file exists';
            }*/
			//Create PHPDocx object using the template file defined above.
			$docx = new CreateDocxFromTemplate($cookie_file_path);
			
            $variables = array();  
			$variables_html = array();
            foreach($value as $k=>$v){
				$k_val = explode("-",$k);
				$e_val = array("SIGNED","PRESENCE","LengthContent");
				if(count($k_val)>1 && in_array($k_val[1],$e_val)){
					$variables_html[$k] = $v;
				}else{
					$variables[$k] = $v;
				}
				
            }
			//Load the array into the PHPDocx object so that the variable values are inserted into the document template.
			$docx->replaceVariableByText($variables);
			if(!empty($variables_html)){
				foreach($variables_html as $hk=>$hv){
					if(!empty($hv)){
						$docx->replaceVariableByHTML($hk, 'inline', $hv, array());
					}else{
						$docx->replaceVariableByText(array($hk=>""));
					}
					

				}
			}
			
			//echo '<br/>About to check if file exists...';
		
            
            if (!file_exists($file['dir_path'].'/doc/temps/cron/')) {
                mkdir($file['dir_path'].'/doc/temps/cron/', 0777, true);
            }
			
			//Define the output location and name of the document to be saved (e.g. Saves in 'Output' folder relative to the location
			//Of this script, and the name of the file will be 'testDeed'.
			$outputWordFileNameAndPath =  $file['dir_path'].'/doc/temps/cron/'.date('ymdhis').$i.'-cron';
			$newfile = $outputWordFileNameAndPath.".docx";
			$newfile_pdf = $outputWordFileNameAndPath.".pdf";
			//Define the base directory
			$baseDirectory = '';

			//Create the document and save it.
			$docx->createDocx($outputWordFileNameAndPath);

			//Conver the document to PDF and save.
			$docx->transformDocxUsingMSWord($baseDirectory.$outputWordFileNameAndPath.'.docx', $baseDirectory.$outputWordFileNameAndPath.'.pdf');
			
			
			if(file_exists($newfile_pdf)){
				//chmod($newfile_pdf, 0777);
				$new_xml['temp_file'][] = $newfile_pdf;
		    	//chmod($newfile_pdf, 0777);
		    }

        }
        	
        	$i++;
    		

    }
    $c = count($new_xml['temp_file']);
    if (!file_exists($file['dir_path'].'/doc/cron/')) {
             mkdir($file['dir_path'].'/doc/cron/', 0777, true);
    }
	$final_doc =$file['dir_path'].'/doc/cron/'.$n;
    $final_doc = str_replace('.docx','.pdf',$final_doc);
    $final_doc  = str_replace("/","\\",$final_doc );
    $final_doc  = str_replace("\\","\\\\",$final_doc );
    $final_doc_url = $file['dir_url'].'/doc/cron/'.$n;
    $final_doc_url = str_replace('.docx','.pdf',$final_doc_url);
    
    if($c>1){
    	
		$alldoc = $new_xml['temp_file'];
    	cron_mergerAllPdf($alldoc,$final_doc);
	  

    }else{
    	copy($new_xml['temp_file'][0], $final_doc);
    }
    if(file_exists($final_doc)){
		
    	chmod($final_doc, 0777);
    	foreach($new_xml['temp_file'] as $y){
			if(file_exists(ConvertDirectoryPath($y))){
				chmod(ConvertDirectoryPath($y),0777);
			}
			
			@unlink(ConvertDirectoryPath($y));
			$y = str_replace(".pdf",".docx",$y);
			@unlink(ConvertDirectoryPath($y));
		}
        
       
        
        cron_SaveToDB($final_doc_url,$final_doc,$entry["id"],$type,$invoice_number);
        return $final_doc_url;
    }
    
    foreach($new_xml['temp_file'] as $y){
        if(file_exists(ConvertDirectoryPath($y))){
            chmod(ConvertDirectoryPath($y),0777);
        }
        
		@unlink(ConvertDirectoryPath($y));
		$y = str_replace(".pdf",".docx",$y);
		@unlink(ConvertDirectoryPath($y));
	}
    
    return "";

}

//Merge All geenrated PDF files to one
function cron_mergerAllPdf($files,$output){

	require_once 'D:\\inetpub\\app\\wwwroot\\wp-content\\plugins\\templatemerge\\phpdocx-v4\\classes\\MultiMerge.inc';
	$merge = new MultiMerge();
	return $merge->mergePdf($files, $output);  
}
  
//Invoice document generation process
function cron_InvoicesMerge($entry,$fields,$invoice_number=""){
    
        $maped_fields = tpl_values_merge($entry,$fields);
		
        $form_id  = $entry['form_id'];
        $params = array('where'=>'form_id = '.$form_id);
        $tpl_list = gettplInvoicesList($params);

        if(!empty($tpl_list['meta']['files'])){
            $files = $tpl_list['meta']['files'];
            $mfileurl = "";

            $proceed = 0;
            $tpls = array();
            $js = 0;
            

            foreach($files as $file){
                
                $tpl_values = array();
                
                if(!empty($file['filepath'])){
                    $proceed = 1;
                    $ofieldvalue = "";
					$ofieldvalue_e = "";
					$ofieldvalue_f = "";
					if(isset($entry[$file['form_field']])){
						$ofieldvalue = explode("|",$entry[$file['form_field']]);    
					}

					if(isset($entry[$file['form_field_e']])){
						$ofieldvalue_e = explode("|",$entry[$file['form_field_e']]);
					}
					if(isset($entry[$file['form_field_f']])){
						$ofieldvalue_f = explode("|",$entry[$file['form_field_f']]);
					}
						

                    if(empty($file['operator_value']) && empty($file['operator_value_e']) && empty($file['operator_value_f'])){
                        $tpls[0] = array('file'=>$file,'values'=>$maped_fields);
                    }else{
                        if(!empty($file['operator_value']) && !empty($file['operator_value_e']) && !empty($file['operator_value_f'])){

                        }elseif(!empty($file['operator_value']) && !empty($file['operator_value_e'])){

                        }elseif(!empty($file['operator_value'])){
                            if(!empty($file['operator_value']) && !empty($file['form_field']) && $file['operator_value'] == $ofieldvalue[0]){
                                $tpls[0] = array('file'=>$file,'values'=>$maped_fields);
                            }else if(empty($file['operator_value']) && !empty($file['form_field']) && !empty($entry[$file['form_field']])){
                                $tpls[0] = array('file'=>$file,'values'=>$maped_fields);                            
                            }
                        }
                    }
            
                   
         
                }
                $js++;
                
            }
        }
       
        if(!empty($tpls)){
       
          $mfileurl =  cron_tpl_merge_process($tpls,$entry,"Invoice",$invoice_number);
        }
        return $mfileurl;

}

//Letter generation process
function cron_LettersMerge($entry,$fields){
    
        $maped_fields = tpl_values_merge($entry,$fields);

        $form_id  = $entry['form_id'];
        $params = array('where'=>'form_id = '.$form_id);
        $tpl_list = gettplLettersList($params);
		            $mfileurl = "";
        if(!empty($tpl_list['meta']['files'])){
            $files = $tpl_list['meta']['files'];

            
            $proceed = 0;
            $tpls = array();
            $js = 0;
            

            foreach($files as $file){
                
                $tpl_values = array();
                
                if(!empty($file['filepath'])){
                    $proceed = 1;
                    $ofieldvalue = explode("|",$entry[$file['form_field']]);
                    $ofieldvalue_e = explode("|",$entry[$file['form_field_e']]);
                    $ofieldvalue_f = explode("|",$entry[$file['form_field_f']]);

                    if(empty($file['operator_value']) && empty($file['operator_value_e']) && empty($file['operator_value_f'])){
                        $tpls[0] = array('file'=>$file,'values'=>$maped_fields);
                    }else{
                        if(!empty($file['operator_value']) && !empty($file['operator_value_e']) && !empty($file['operator_value_f'])){

                        }elseif(!empty($file['operator_value']) && !empty($file['operator_value_e'])){

                        }elseif(!empty($file['operator_value'])){
                            if(!empty($file['operator_value']) && !empty($file['form_field']) && $file['operator_value'] == $ofieldvalue[0]){
                                $tpls[0] = array('file'=>$file,'values'=>$maped_fields);
                            }else if(empty($file['operator_value']) && !empty($file['form_field']) && !empty($entry[$file['form_field']])){
                                $tpls[0] = array('file'=>$file,'values'=>$maped_fields);                            
                            }
                        }
                    }
            
                   
         
                }
                $js++;
                
            }
        }

       
        if(!empty($tpls)){
       
          $mfileurl =  cron_tpl_merge_process($tpls,$entry,"Letter");
        }   
       
    return $mfileurl;

  
}


// save and update generated document url into DB 
function cron_SaveToDB($file_url,$file_path,$lead_id,$type="",$invoice_number=""){
        $wpdb = new wpdb('tpocom_dash','w2P!9A-Si0','tpocom_dash','localhost');
        
        $table_name = TemplateData::get_tpl_docs_table_name();
        
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE lead_id= %d ORDER BY id DESC LIMIT 0,1",$lead_id);
        
        $results = $wpdb->get_results($sql, ARRAY_A);
        if(empty($results))
            return array();

        if(!empty($results)){
            
            if($type=="Letter"){
                $values =  array("letters_url" => $file_url,"letters_path" => $file_path);
            }else if($type=="Invoice"){

                $values =  array("invoices_url" => $file_url,"invoices_path" => $file_path,"invoice_number"=>$invoice_number);
            }else{
				$values =  array("file_url" => $file_url,"file_path" => $file_path);
			}

          return $return =  $wpdb->update($table_name,$values, array("lead_id" => $lead_id), array("%s", "%s"), array("%d"));
        }

        return true;

}
//Update cron status into DB
function cron_statusUpdate($lead_id,$status,$message){
		$wpdb = new wpdb('tpocom_dash','w2P!9A-Si0','tpocom_dash','localhost');
        
        $table_name = TemplateData::get_tpl_docs_table_name();
        
        $values =  array("cron_status" => $status,"cron_desc" => $message);
        $return =  $wpdb->update($table_name,$values, array("lead_id" => $lead_id), array("%d", "%s"), array("%d"));

        return true;
       
}

?>
