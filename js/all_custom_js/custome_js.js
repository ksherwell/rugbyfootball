//Variable for the popup center calculation start
var win_width=0;
	
var half_win_width=0;

var modal_left=0;

var win_height=0;

var half_win_height=0;

var modal_top=0;


var dynamic_scroll_top_pid="";
//Variable for the popup center calculation end


jQuery(document).ready(function($){
	
	//Home page start
	
		//Home page slider start
		
		
		 jQuery('#home_slider').bxSlider({
            auto: true,
            mode: 'horizontal',		   
            nextSelector: '#next2',
            prevSelector: '#prev2',
            responsive: true,
            adaptiveHeight: true
         }); 
		
		//Home page slider end
		
		
		//Home page membership package slider
		
		
		
		 jQuery('#home_slider_membership').bxSlider({
                    auto: true,
                    mode: 'horizontal',
		    minSlides: 9,
		    maxSlides: 9,
                    nextSelector: '#next22',
		    prevSelector: '#prev22'    
		                
                    
                  }); 
		
		//Home page membership package slider end
		

    // Responsive Nav
    var toggleResponsiveNav = $('#toggleResponsiveNav'),
        pageContent = $('div.page'),
        responsiveNav = $('#responsiveNav'),
        closeResponsiveNav = $('#closeResponsiveNav'),
        originalNav = $('#nav'),
        navVisible = false;

    // clone nav
    var navClone = originalNav.clone(false);
    navClone.attr('id','');

    navClone.prepend($('<li class="cart"><a href="/wishlist/">Wishlist</a></li>'));
    navClone.prepend($('<li class="cart"><a href="/checkout/cart/">Shopping Cart</a></li>'));

    responsiveNav.append(navClone);

    toggleResponsiveNav.on('click', function() {

        if( !navVisible ) {
            showResponsiveNav();
        } else {
            hideResponsiveNav();
        }

    });

    closeResponsiveNav.on('click', function() {
        hideResponsiveNav();
    });

    function showResponsiveNav() {
        pageContent.addClass('nav-visible');
        responsiveNav.addClass('nav-visible');
        closeResponsiveNav.show();
        navVisible = true;
    }

    function hideResponsiveNav() {
        pageContent.removeClass('nav-visible');
        responsiveNav.removeClass('nav-visible');
        closeResponsiveNav.hide();
        navVisible = false;
    }

    responsiveNav.find('> ul > li').each(function() {
        var li = $(this),
            a = li.find('> a'),
            childUL = li.find('> ul');

        if(childUL.length > 0) {
            childUL.data('original-height', childUL.height());
            childUL.css('height', 0);

            a.addClass('has-sub-menu');

            a.click(function(e) {
                e.preventDefault();

                if( childUL.height() === 0 ) {
                    childUL.css('height', childUL.data('original-height'));
                    a.addClass('sub-menu-open');
                } else {
                    childUL.css('height', 0);
                    a.removeClass('sub-menu-open');
                }

            });

        }


    });

		
	//Home page end
	
	
	//Listing page start
		
		//custom pagination dropdown initiation start
		
		jQuery(".drop_val_con").unbind("click");
		jQuery(".drop_val_con").bind("click",{"val_display_id":"drop_val_con","list_ul_id":"drop_val_list","cls_nm":"pg_list","duration":500},gen_cus_drop_down);
		
		jQuery(".drop_val_list li").unbind("click");
		jQuery(".drop_val_list li").bind("click",{"val_display_id":"drop_val_con","list_ul_id":"drop_val_list","cls_nm":"pg_list","duration":500},fetch_cus_drop_down);
		
		//custom pagination dropdown initiation start
		
		
	//Listing page end
	
	
	//Details page start
	
		 //Fetch all options from option dl dt and place in in a div Start
				  
				  
				  if(jQuery("#product-options-wrapper .new-tracker").length>0)
				  {
						   var tmp_con="";
						   
						   jQuery("#product-options-wrapper .new-tracker").each(function(){
								    tmp_con+=jQuery(this).html();
								    jQuery(this).remove();		    
								    
								    
						   });
						   
						   
						   //alert(jQuery(".product-options-bottom").find(".mande_txt").attr("class"));
						   
						   jQuery(".product-options-bottom").find(".mande_txt").before('<div class="custom-option-area"><dl>'+tmp_con+'</dl></div>');
						   
						   
						   generate_custom_option_dropdown();
						   
						   
						   
						   
				  }
				  
		 
		 
		 //Fetch all options from option dl dt and place in in a div End
	
	
	
	
	
	
	
		 //Configurable product custom drop down start
				  jQuery(".cus_ul_li_cl").each(function(){
						   
						   
						   var curr_iid=jQuery(this).attr("id");
						   var tmp_str="";
						   
						   tmp_str+='<span class="drop_val_config '+jQuery(this).attr("id")+'_con" id="'+jQuery(this).attr("id")+'_con"></span>';
						   
						   tmp_str+='<ul class="drop_val_list_config '+jQuery(this).attr("id")+'_config" id="'+jQuery(this).attr("id")+'_config" style="display:none;">';
						   
						   
						   jQuery(".cus_ul_li_cl option").each(function(){
								    
								tmp_str+='<li class="pg_list_config '+curr_iid+'_pg_list" alt="'+jQuery(this).attr("value")+'">';    
								    
								tmp_str+=jQuery(this).text();
								
								tmp_str+='</li>';
								
						   });
						   
						   
						   
						   
						   
						   tmp_str+='</ul>';
						
						
						//alert(tmp_str);
						
						jQuery("#"+curr_iid).parent(".cus_ul_li_con").append(tmp_str);
						
						if(jQuery(".cus_ul_li_cl option:nth-child(1)").text()!="")
						{
						   jQuery("#"+curr_iid+"_con").html(jQuery(".cus_ul_li_cl option:nth-child(1)").text());
						   jQuery("#"+curr_iid+"_config li:nth-child(1)").html(jQuery(".cus_ul_li_cl option:nth-child(1)").text());
						   
						   
						   
						   jQuery("."+curr_iid+"_con").unbind("click");
						   jQuery("."+curr_iid+"_con").bind("click",{"val_display_id":curr_iid+"_con","list_ul_id":curr_iid+"_config","cls_nm":"pg_list_config","duration":500},gen_cus_drop_down);
						   
						   jQuery("."+curr_iid+"_config li").unbind("click");
						   jQuery("."+curr_iid+"_config li").bind("click",{"val_display_id":curr_iid+"_con","list_ul_id":curr_iid+"_config","cls_nm":"pg_list_config","duration":500},fetch_cus_drop_down_conf);
						   
						   
						}
				  
						
						
						
				  });
	
		 //Configurable product custom drop down end
		 
		 //Code for details page pop up start
		 
		 jQuery(".product-img-box .product-image").click(function(){
				  
			jQuery(".cus_product_pop").css("display","block");
			jQuery(".pro_det_overlay").css("display","block");
				  
				  
		 });
		 
		  jQuery("#cross_it").click(function(){
				  
			jQuery(".cus_product_pop").css("display","none");
			jQuery(".pro_det_overlay").css("display","none");
				  
				  
		 });
		 
		 //Code for details page pop up end
		 
		 //360 image rotation start
		 
		

		 //l'array ARR va contenir la liste des images
		 arr_all_img = Array();
		 //trop lazy pour tout taper...
		 var img_str=jQuery("#all_img").attr("value");
		 
		 if(jQuery.trim(img_str)!="")
		 {
				  arr_all_img=img_str.split(",,");
				  
				  /*for (var x=1450; x<= 1480; x+=4)
					  arr.push("MAT_" +x + ".jpg");
				  */
				  
				  //alert(arr_all_img.length);
				  //bindons le widget rotate ï¿½ l'image pic avec la liste d'image arr
				  jQuery("#mvmvmv").threesixty({images:arr_all_img, method:'mousemove', 'cycle':2, direction:"backward",sensibility: 1});
				  
				  //$("#click").threesixty({images:arr2, method:'click', 'cycle':1, 'resetMargin': 10});
				  //$("#auto").threesixty({images:arr2, method:'auto', autoscrollspeed:100});
		 }
				  
		
		 
		 
		 
		 
		 //360 image rotation end
		 
		 
		 //Pop up small image click and display large start
		 jQuery(".all_thumbs").click(function(){
				  
				  //alert(jQuery(this).attr("alt"));
				  jQuery(".all_thumbs").removeClass("active");
				  jQuery(this).addClass("active");
				  
				  var current_clicked_image_name=jQuery(this).attr("alt");
				  
				  jQuery("#three_sixty_block").css("display","none");
				  
				  jQuery("#normal_block").css("display","block");
				  //alert(current_clicked_image_name);
				  jQuery("#normal_big_image").attr("src",current_clicked_image_name);
				  
				  
				  
		 });
		 
		 jQuery(".more_im").click(function(){
				  
				  var curr_index=jQuery(this).index()+1;
				  
				  jQuery("#three_sixty_block").css("display","none");
				  
				  jQuery("#normal_block").css("display","block");
				  
				  jQuery(".all_thumbs:nth-child("+curr_index+")").trigger("click");
				  
				  jQuery(".cus_product_pop").css("display","block");
				  jQuery(".pro_det_overlay").css("display","block");
		 });
		 
		 
		 
		 //Pop up small image click and display large end
		 
		 //Enable 360 start		 
		 jQuery("#enable_three_sixty,#enable_three_sixty_med").click(function(){
				
		 				
				  jQuery("#cus_product_pop").css("display","block");
				   
				  jQuery("#three_sixty_block").css("display","block");
				  
				  jQuery("#normal_block").css("display","none");
				  
				  
				  
		 });
		 
		 //Enable 360 end
		 
		 //Hide show 360 depending on images are available or not start
		 if(jQuery.trim(jQuery("#all_img").attr("value"))=="")
		 {
			jQuery("#enable_three_sixty,#enable_three_sixty_med").css("display","none");
			jQuery("#enable_three_sixty").parent().css("display","none");
		 }
		  //Hide show 360 depending on images are available or not end
		 
	
	//Details page end
	
	
	//Cart page start
		 //Cart page detals view hide beside image start
				  jQuery(".det_txt").click(function(){
						  
						   if(jQuery(this).next(".det_view").css("display")=="none")
						   {
								    jQuery(this).next(".det_view").slideDown(500);
								    jQuery(this).addClass("active");
						   }
						   else
						   {
								    jQuery(this).next(".det_view").slideUp(500);
								    jQuery(this).removeClass("active");
						   }
						   
				  });
		 
		 
		 
	
		 //Cart page detals view hide beside image end
	//Cart page end
	
	
	//Footer popup open close start
	jQuery("#close_down").addClass("active");
	
	jQuery("#open_up").click(function(){
		
		 /*dynamic_scroll_top_pid=setInterval(function go(){
				  
				  jQuery(window).scrollTop(70000);
				  
		 },0);*/
		 
		 jQuery("#close_down").removeClass("active");
		 jQuery(this).addClass("active");
		 
		 
		 jQuery(".poppup_list").animate({"height":"160px"},1000,function(){
				  
			//clearInterval(dynamic_scroll_top_pid);	  
				  
		 });	 
		 
		 
	});
	
	jQuery("#close_down").click(function(){
		 
		
		jQuery("#open_up").removeClass("active");
		jQuery(this).addClass("active"); 
		 
		jQuery(".poppup_list").animate({"height":"0px"},1000);
		
		 
		 
	});
	
		 //Footer cart slider start
		 jQuery('#footer_slider_cart').bxSlider({
                    auto: false,
                    mode: 'horizontal',		   
                    nextSelector: '#next_cart',
		    prevSelector: '#prev_cart'    
		                
                    
                 }); 	 
	
		//Footer cart slider end
		
		//Footer compare slider start
		 jQuery('#footer_slider_compare').bxSlider({
                    auto: false,
                    mode: 'horizontal',		   
                    nextSelector: '#next_compare',
		    prevSelector: '#prev_compare'    
		                
                    
                 }); 	 
	
		//Footer compare slider end
		
		//Footer wishlist slider start
		 jQuery('#footer_slider_wish').bxSlider({
                    auto: false,
                    mode: 'horizontal',		   
                    nextSelector: '#next_wish',
		    prevSelector: '#prev_wish'    
		                
                    
                 }); 	 
	
		//Footer wishlist slider end
	//Footer popup open close end
});

//Home big pop function start

function open_big_popup(e)
{
	
	
	win_width=jQuery(window).width()-6;

	half_win_width=win_width/2;
	
	modal_left=half_win_width-350;
	
	win_height=jQuery(window).height()-6;
	
	half_win_height=win_height/2;
	
	modal_top=half_win_height-250;
	
	
	var stop=jQuery(window).scrollTop();
	
	
	
	
	
	jQuery(".details_pop").css("left",modal_left+"px");
	jQuery(".details_pop").css("top",(modal_top+stop)+"px");
	
	
	
	
	last_object_clicked=jQuery(this);
	
	var img_src=last_object_clicked.find(".im_src").attr("value");
	var url_src=last_object_clicked.find(".url_src").attr("value");
	var cap_txt=last_object_clicked.find(".cap_src").attr("value");
	
	//alert(img_src+"  "+url_src);
	
	jQuery("#shop_this_look").attr("href",url_src);
	
	jQuery("#big_img_p").attr("src",img_src);
		
	jQuery("#p_big_txt").html(cap_txt);
	
	
	jQuery(".details_pop").css("display","block");
	jQuery("#pop_up_overlay").css("display","block");
	
	
	
	
	
}


 // Removes leading whitespaces
function LTrim( value ) {
	
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
	
}

// Removes ending whitespaces
function RTrim( value ) {
	
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
	
}

// Removes leading and ending whitespaces
function trim( value ) {
	
	return LTrim(RTrim(value));
	
}

//Custom drop down code for configurable products area in details page start

function fetch_cus_drop_down_conf(e)
{
	
	
	var curr_limit_url=jQuery(this).attr("alt");
	var curr_val=trim(jQuery(this).html());
	var curr_index=jQuery(this).index()+1;
	
	
	
	jQuery("."+e.data.val_display_id).html(curr_val);
	 
	jQuery("."+e.data.list_ul_id).slideUp(e.data.duration);
	
	jQuery("."+e.data.list_ul_id+" li").removeClass("active");
	jQuery(this).addClass("active");
	
	
	jQuery("."+e.data.val_display_id).parent().find("select option:nth-child("+curr_index+")").attr("selected","selected");
	
	
}





//Custom drop down code for configurable products area in details page end



//Generalized code to create custom drop down start Use it using bind and unbind function

function gen_cus_drop_down(e)
{
	//alert(e.data.val_display_id+"   "+e.data.list_ul_id+"  "+e.data.duration);
	
	
	if(jQuery("."+e.data.list_ul_id).css("display")=="none")
	{
		 
		 jQuery("."+e.data.list_ul_id).slideDown(e.data.duration);
		 jQuery(this).addClass("active");
	}
	else if(jQuery("."+e.data.list_ul_id).css("display")=="block" && e.target.className!=e.data.cls_nm)
	{
		 jQuery("."+e.data.list_ul_id).slideUp(e.data.duration);
		 jQuery(this).removeClass("active");
	}
	
	
	
}

function fetch_cus_drop_down(e)
{
	
	
	var curr_limit_url=jQuery(this).attr("alt");
	var curr_val=trim(jQuery(this).html());
	
	
	jQuery("."+e.data.val_display_id).html(curr_val);
	 
	jQuery("."+e.data.list_ul_id).slideUp(e.data.duration);
	
	jQuery("."+e.data.list_ul_id+" li").removeClass("active");
	jQuery(this).addClass("active");
	
	setLocation(curr_limit_url);
	
}



//Generalized code to create custom drop down end


//Generalized code to generate custome option drop down start
function generate_custom_option_dropdown()
{
		 var ct_cus=0;
		 jQuery(".custom-option-area .input-box select").each(function(){
			
			ct_cus++;	  
				  
			var curr_id=jQuery(this).attr("id");
			
			var new_id=curr_id+"__"+ct_cus;
			
			jQuery(this).css("display","none");
				  
			var cus_op_div='';
			
			cus_op_div+='<div class="cus-div-gen">';
			
			var cus_op_ul="";
			cus_op_ul+='<ul class="'+new_id+'">';
			
			var start_li=0;
			jQuery("#"+curr_id+" option").each(function(){
				start_li++;
				
				var opt_val=jQuery(this).attr("value");
				var opt_text=jQuery(this).text();
				
				
				if(start_li==1)
				{
				  cus_op_div+='<span class="drop_val_option" id="page_val_con_'+new_id+'">'+opt_text+'</span>';
				  cus_op_ul+='<li class="opt_list active" alt="'+opt_val+'">'+opt_text+'</li>';
				}
				else
				{
				  cus_op_ul+='<li class="opt_list" alt="'+opt_val+'">'+opt_text+'</li>';
				}
				  
				 
				  
		        });
			
			cus_op_ul+='</ul>';
			
			cus_op_div+=cus_op_ul;
			
			cus_op_div+='</div>';
			
			jQuery(this).parent().append(cus_op_div);
			
			jQuery("#page_val_con_"+new_id).unbind("click");
		        jQuery("#page_val_con_"+new_id).bind("click",{"val_display_id":"drop_val_option","list_ul_id":new_id,"cls_nm":"opt_list","duration":500},gen_cus_drop_down);	  
			
			jQuery("."+new_id+" li").unbind("click");
		        jQuery("."+new_id+" li").bind("click",{"val_display_id":"drop_val_option","list_ul_id":new_id,"cls_nm":"opt_list","duration":500},set_cus_drop_down_option);
		 });
		 
		 
		 
		 
}
function set_cus_drop_down_option(e)
{
	
	//alert("sadasd");
	var curr_limit_url=jQuery(this).attr("alt");
	var curr_val=trim(jQuery(this).html());
	
	
	jQuery("#page_val_con_"+e.data.list_ul_id).html(curr_val);
	 
	jQuery("."+e.data.list_ul_id).slideUp(e.data.duration);
	
	jQuery("."+e.data.list_ul_id+" li").removeClass("active");
	jQuery(this).addClass("active");
	
	
	jQuery(this).parent().parent().parent().find("select option[value='"+jQuery(this).attr("alt")+"']").attr("selected",true);
	
	//setLocation(curr_limit_url);
	
}

//Generalized code to generate custome option drop down end
