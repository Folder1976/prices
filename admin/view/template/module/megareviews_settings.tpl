<?php echo $header; ini_set('display_errors',0);
error_reporting(0); ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-options" data-toggle="tab"><?php echo $tab_options; ?></a></li>
            <li><a href="#tab-aboutyou" data-toggle="tab"><?php echo $tab_aboutyou; ?></a></li>
            <li><a href="#tab-layout" data-toggle="tab"><?php echo $tab_layout; ?></a></li>
            <li><a href="#tab-multimedia" data-toggle="tab"><?php echo $tab_multimedia; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_status; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($module['mr_status']) { ?>
                        <input type="radio" name="mr[mr_status]" value="1" checked="checked" />
                        <?php echo $text_enabled; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[mr_status]" value="1" />
                        <?php echo $text_enabled; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$module['mr_status']) { ?>
                        <input type="radio" name="mr[mr_status]" value="0" checked="checked" />
                        <?php echo $text_disabled; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[mr_status]" value="0" />
                        <?php echo $text_disabled; ?>
                        <?php } ?>
                      </label>
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_approve; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($module['approve']) { ?>
                        <input type="radio" name="mr[approve]" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[approve]" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$module['approve']) { ?>
                        <input type="radio" name="mr[approve]" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[approve]" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
                  </div>
                  
				  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_captcha; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($module['captcha']) { ?>
                        <input type="radio" name="mr[captcha]" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[captcha]" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$module['captcha']) { ?>
                        <input type="radio" name="mr[captcha]" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[captcha]" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" ><span data-toggle="tooltip" title="<?php echo $help_fieldsopts; ?>"><?php echo $text_fieldsopts; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="mr[rvalues]" value="<?php echo $module['rvalues']; ?>"  class="form-control" />
                    </div>
                  </div>
                  
				<div class="col-sm-12">
					<h3><?php echo $text_fieldsopts; ?></h3>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_orating; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <input type="radio" name="mr[rating]" value="0" <?php if ($module['rating']==0) echo' checked="checked"' ?> />
                        <?php echo $text_hide; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[rating]" value="1" <?php if ($module['rating']==1) echo' checked="checked"' ?> />
                        <?php echo $text_show; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[rating]" value="2" <?php if ($module['rating']==2) echo' checked="checked"' ?> />
                        <?php echo $text_required; ?>
                      </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_recommend; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <input type="radio" name="mr[recommend]" value="0" <?php if ($module['recommend']==0) echo' checked="checked"' ?> />
                        <?php echo $text_hide; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[recommend]" value="1" <?php if ($module['recommend']==1) echo' checked="checked"' ?> />
                        <?php echo $text_show; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[recommend]" value="2" <?php if ($module['recommend']==2) echo' checked="checked"' ?> />
                        <?php echo $text_required; ?>
                      </label>
                    </div>
                </div>
		
				<div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_nickname; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <input type="radio" name="mr[nickname]" value="0" <?php if ($module['nickname']==0) echo' checked="checked"' ?> />
                        <?php echo $text_hide; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[nickname]" value="1" <?php if ($module['nickname']==1) echo' checked="checked"' ?> />
                        <?php echo $text_show; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[nickname]" value="2" <?php if ($module['nickname']==2) echo' checked="checked"' ?> />
                        <?php echo $text_required; ?>
                      </label>
                    </div>
                </div>
	            
	            <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_rtitle; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <input type="radio" name="mr[title]" value="0" <?php if ($module['title']==0) echo' checked="checked"' ?> />
                        <?php echo $text_hide; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[title]" value="1" <?php if ($module['title']==1) echo' checked="checked"' ?> />
                        <?php echo $text_show; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[title]" value="2" <?php if ($module['title']==2) echo' checked="checked"' ?> />
                        <?php echo $text_required; ?>
                      </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_rtext; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <input type="radio" name="mr[text]" value="1" <?php if ($module['text']==1) echo' checked="checked"' ?> />
                        <?php echo $text_show; ?>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="mr[text]" value="2" <?php if ($module['text']==2) echo' checked="checked"' ?> />
                        <?php echo $text_required; ?>
                      </label>
                    </div>
                </div>
	            
	            <div class="form-group">
	                <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                      <label class="col-sm-3 control-label" ><span data-toggle="tooltip" title="<?php echo $help_rtextcount; ?>"><?php echo $s_rtextcount; ?></span></label>
                      <div class="col-sm-3"><input type="text" name="mr[textcount]" value="<?php echo $module['textcount']; ?>"  class="form-control" /></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                      <label class="col-sm-3 control-label" ><span data-toggle="tooltip" title="<?php echo $help_rtextcounter; ?>"><?php echo $s_rtextcounter; ?></span></label>
                      <input type="hidden" name="mr[displaytextcounter]" value="0" />
                      <div class="col-sm-3"><input type="checkbox" name="mr[displaytextcounter]" <?php if ($module['displaytextcounter']) echo'checked="checked"'; ?> class="form-control" /></div>
                    </div>
                </div>
                
				<div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_rtexthint; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="mr[texthint]" value="<?php echo $module['texthint']; ?>"  class="form-control" />
                    </div>
                </div>
	            
	            <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_rtitlehint; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="mr[titlehint]" value="<?php echo $module['titlehint']; ?>"  class="form-control" />
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_texttips; ?></label>
                    <div class="col-sm-6">
                      <textarea cols="80" rows="5" name="mr[texttips]" class="form-control"><? echo $module['texttips']; ?></textarea>
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" name="mr[displaytexttips]" value="0" />
                      <input type="checkbox" name="mr[displaytexttips]" <?php if ($module['displaytexttips']) echo'checked="checked"'; ?> class="form-control" />
                      <?php echo $s_show; ?>
                    </div>
                </div>
						
		</div>
		<div class="tab-pane" id="tab-options">
            <div class="table-responsive">
                <table id="options" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_optname; ?></td>
                      <td class="text-left"><?php echo $entry_optmin; ?></td>
                      <td class="text-left"><?php echo $entry_optmax; ?></td>
                      <td class="text-left"><?php echo $entry_optvalues; ?></td>
                      
                      <td class="text-right"><?php echo $entry_optsort; ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $omodule_row = 0; ?>
                      <?php foreach ($options as $option) { ?>
                      <tr id="option-row<?php echo $omodule_row; ?>">
                          <td class="text-left"><input type="text" name="options[<?php echo $omodule_row; ?>][name]" value="<?php echo $option['name']; ?>" size="15" /></td>
                          <td class="text-left"><input type="text" name="options[<?php echo $omodule_row; ?>][min]" value="<?php echo $option['min']; ?>" size="15" /></td>
                          <td class="text-left"><input type="text" name="options[<?php echo $omodule_row; ?>][max]" value="<?php echo $option['max']; ?>" size="15" /></td>
                          <td class="text-left"><input type="text" name="options[<?php echo $omodule_row; ?>][values]" value="<?php echo $option['values']; ?>" size="30" /></td>
                          
                          <td class="text-right"><input type="text" name="options[<?php echo $omodule_row; ?>][sort_order]" value="<?php echo $option['sort_order']; ?>" size="3" /></td>
                          <td class="text-left"><button type="button" onclick="$('#option-row<?php echo $omodule_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                     
                      <?php $omodule_row++; ?>
                      <?php } ?>
                       </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="5"></td>
                          <td class="left"><button type="button" onclick="addOption();" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                </table>
             </div>  
             
             <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_displayoptions; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($module['displayoptions']) { ?>
                        <input type="radio" name="mr[displayoptions]" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[displayoptions]" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$module['displayoptions']) { ?>
                        <input type="radio" name="mr[displayoptions]" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[displayoptions]" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
            </div>     
        </div>            
          
        
        <div class="tab-pane" id="tab-aboutyou">
            <div class="table-responsive">
                <table id="aboutyou" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_aycaption; ?></td>
                  
                      <td class="text-left"><?php echo $entry_ayvalues; ?></td>
                      
                      <td class="text-right"><?php echo $entry_aysort; ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $amodule_row = 0; ?>
                      <?php foreach ($ays as $ay) { ?>
                      <tr id="aboutyou-row<?php echo $amodule_row; ?>">
                          <td class="text-left"><input type="text" name="ay[<?php echo $amodule_row; ?>][name]" value="<?php echo $ay['name']; ?>" size="15" /></td>
                          <td class="text-left"><input type="text" name="ay[<?php echo $amodule_row; ?>][values]" value="<?php echo $ay['values']; ?>" size="30" /></td>
                          
                          <td class="text-right"><input type="text" name="ay[<?php echo $amodule_row; ?>][sort_order]" value="<?php echo $ay['sort_order']; ?>" size="3" /></td>
                          <td class="text-left"><button type="button" onclick="$('#aboutyou-row<?php echo $amodule_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                      
                      <?php $amodule_row++; ?>
                      <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3"></td>
                          <td class="left"><button type="button" onclick="addAboutyou();" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                </table>
             </div>  
             
             <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_displayaboutyou; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($module['displayaboutyou']) { ?>
                        <input type="radio" name="mr[displayaboutyou]" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[displayaboutyou]" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$module['displayaboutyou']) { ?>
                        <input type="radio" name="mr[displayaboutyou]" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[displayaboutyou]" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
            </div>     
        </div> 
        
        
        
        <div class="tab-pane"  id="tab-layout">
		    
		    <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_position; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($module['mr_position']=="content_bottom") { ?>
                        <input type="radio" name="mr[mr_position]" value="content_bottom" checked="checked" />
                        <?php echo $s_positionbottom; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[mr_position]" value="content_bottom" />
                        <?php echo $s_positionbottom; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if ($module['mr_position']=="content_mr") { ?>
                        <input type="radio" name="mr[mr_position]" value="content_mr" checked="checked" />
                        <?php echo $s_positiontab; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[mr_position]" value="content_mr" />
                        <?php echo $s_positiontab; ?>
                        <?php } ?>
                      </label>
                    </div>
            </div>  
		    <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $s_perpage; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="mr[perpage]" value="<?php echo $module['perpage']; ?>"  class="form-control" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $s_sort; ?></label>
                <div class="col-sm-10">
                    <input type="hidden" name="mr[sortnewest]" value="0" />
                    <input type="hidden" name="mr[sorthelpful]" value="0" />
                    <input type="hidden" name="mr[sortlowest]" value="0" />
                    <input type="hidden" name="mr[sorthighest]" value="0" />
                    <input type="checkbox" name="mr[sortnewest]" <?php if ($module['sortnewest']) echo'checked="checked"'; ?> class="form-control" />
                    <?php echo $s_sortnewest; ?>
                    <input type="checkbox" name="mr[sorthelpful]" <?php if ($module['sorthelpful']) echo'checked="checked"'; ?> class="form-control" />
                    <?php echo $s_sorthelpful; ?>
                    <input type="checkbox" name="mr[sortlowest]" <?php if ($module['sortlowest']) echo'checked="checked"'; ?> class="form-control" />
                    <?php echo $s_sortlowest; ?>
                    <input type="checkbox" name="mr[sorthighest]" <?php if ($module['sorthighest']) echo'checked="checked"'; ?> class="form-control" />
                    <?php echo $s_sorthighest; ?>
                </div>
            </div>
                
			<div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_vote; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($module['vote']) { ?>
                        <input type="radio" name="mr[vote]" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[vote]" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$module['vote']) { ?>
                        <input type="radio" name="mr[vote]" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[vote]" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
            </div>      		
	          
        </div>
        
        
        
        
        
        <div class="tab-pane"  id="tab-multimedia">
		
		      <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $s_photo; ?></label>
                    <div class="col-sm-8">
                      <label class="radio-inline">
                        <?php if ($module['photo']) { ?>
                        <input type="radio" name="mr[photo]" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[photo]" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$module['photo']) { ?>
                        <input type="radio" name="mr[photo]" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[photo]" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
            </div>  
            <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $s_video; ?></label>
                    <div class="col-sm-8">
                      <label class="radio-inline">
                        <?php if ($module['video']) { ?>
                        <input type="radio" name="mr[video]" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[video]" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$module['video']) { ?>
                        <input type="radio" name="mr[video]" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="mr[video]" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
            </div> 
			 
	        <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $s_maxsize; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="mr[maxsize]" value="<?php echo $module['maxsize']; ?>"  class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $s_maxnumber; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="mr[maxnumber]" value="<?php echo $module['maxnumber']; ?>"  class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $s_minwidth; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="mr[minwidth]" value="<?php echo $module['minwidth']; ?>"  class="form-control" />
                </div>
            </div>   
            
            <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $s_imagehint; ?></label>
                    <div class="col-sm-7">
                      <input type="text" name="mr[imagehint]" value="<?php echo $module['imagehint']; ?>"  class="form-control" />
                   </div>
                    <div class="col-sm-2">
                       <input type="hidden" name="mr[displayimagehint]" value="0" />  
                      <input type="checkbox" name="mr[displayimagehint]" <?php if ($module['displayimagehint']) echo'checked="checked"'; ?> class="form-control" />
                      <?php echo $s_show; ?>
                    </div>
            </div>
            
            <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_videohint; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="mr[videohint]" value="<?php echo $module['videohint']; ?>"  class="form-control" />
                   </div>
                    <div class="col-sm-2">
                        <input type="hidden" name="mr[displayvideohint]" value="0" />
                      <input type="checkbox" name="mr[displayvideohint]" <?php if ($module['displayvideohint']) echo'checked="checked"'; ?> class="form-control" />
                      <?php echo $s_show; ?>
                    </div>
            </div>
                         
	        <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_captionhint; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="mr[captionhint]" value="<?php echo $module['captionhint']; ?>"  class="form-control" />
                    </div>
                    <div class="col-sm-2">
                        <input type="hidden" name="mr[displaycaptionhint]" value="0" />
                      <input type="checkbox" name="mr[displaycaptionhint]" <?php if ($module['displaycaptionhint']) echo'checked="checked"'; ?> class="form-control" />
                      <?php echo $s_show; ?>
                    </div>
            </div>
           <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_imagetips; ?></label>
                    <div class="col-sm-6">
                      <textarea cols="80" rows="5" name="mr[imagetips]" class="form-control"><? echo $module['imagetips']; ?></textarea>
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" name="mr[displayimagetips]" value="0" />
                      <input type="checkbox" name="mr[displayimagetips]" <?php if ($module['displayimagetips']) echo'checked="checked"'; ?> class="form-control" />
                      <?php echo $s_show; ?>
                    </div>
            </div>
            <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $s_videotips; ?></label>
                    <div class="col-sm-6">
                      <textarea cols="80" rows="5" name="mr[videotips]" class="form-control"><? echo $module['videotips']; ?></textarea>
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" name="mr[displayvideotips]" value="0" />
                      <input type="checkbox" name="mr[displayvideotips]" <?php if ($module['displayvideotips']) echo'checked="checked"'; ?> class="form-control" />
                      <?php echo $s_show; ?>
                    </div>
            </div>		
		
		</div>
       </div> 
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var omodule_row = <?php echo $omodule_row; ?>;

function addOption() {	
	var html='';
	html += '<tr id="option-row'+omodule_row+'">';
    html += '          <td class="text-left"><input type="text" name="options['+omodule_row+'][name]" size="15" /></td>';
    html += '          <td class="text-left"><input type="text" name="options['+omodule_row+'][min]" size="15" /></td>';
    html += '          <td class="text-left"><input type="text" name="options['+omodule_row+'][max]"  size="15" /></td>';
    html += '          <td class="text-left"><input type="text" name="options['+omodule_row+'][values]" size="30" /></td>';
        
    html += '          <td class="text-right"><input type="text" name="options['+omodule_row+'][sort_order]"  size="3" /></td>';
    html += '          <td class="text-left"><button type="button" onclick="$(\'#option-row'+omodule_row+'\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '        </tr>';
    
	
	$('#options tbody').append(html);
	
	omodule_row++;
}
var amodule_row = <?php echo $amodule_row; ?>;
function addAboutyou() {	
	var html='';
	html += '<tbody id="aboutyou-row'+amodule_row+'">';
    html += '        <tr>';
              
    html += '          <td class="text-left"><input type="text" name="ay['+amodule_row+'][name]" size="15" /></td>';
   
    html += '          <td class="text-left"><input type="text" name="ay['+amodule_row+'][values]" size="30" /></td>';
    
        
    html += '          <td class="text-right"><input type="text" name="ay['+amodule_row+'][sort_order]"  size="3" /></td>';
    html += '          <td class="text-left"><button type="button" onclick="$(\'#aboutyou-row'+amodule_row+'\').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '        </tr>';
         
	html += '</tbody>';
	
	$('#aboutyou tfoot').before(html);
	
	amodule_row++;
}

$('#tabs a').tabs(); 
//--></script> 
<?php echo $footer; ?>