<div id="myModal" class="modal fade custom_size" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 class="title">@lang('messages.INDIVIDUAL_SIZE')</h1>
            </div>
            <div class="modal-body clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col_center my_custom_50">
                    <div class="group">
                        <label>@lang('messages.BREAST_HEIGH')</label>
                        <input id="Breast_Heigh" type="text" placeholder="5 - 50" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/breast_heigh.jpg';">
                        <span class="err_breast_heigh"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.SHOULDER_WIDTH')</label>
                        <input id="Shoulder_Width" type="text" placeholder="20 - 100" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/shoulder_width.jpg';">
                        <span class="err_shoulder_width"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.BACK_WIDTH')</label>
                        <input id="Back_width" type="text" placeholder="20 - 60" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/back_width.jpg';">
                        <span class="err_back_width"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.FROM_ARMPIT_TO_ARMPIT')</label>
                        <input id="Shirina_pílochki" type="text" placeholder="20 - 60" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/shirina_pilochki.jpg';">
                        <span class="err_shirina_pílochki"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.BREAST_VOLUME')</label>
                        <input id="Breast_volume" type="text" placeholder="50 - 150" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/breast_volume.jpg';">
                        <span class="err_breast_volume"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.WAIST')</label>
                        <input id="Waist" type="text" placeholder="50 - 150" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/waist.jpg';">
                        <span class="err_waist"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.HIPS_VOLUME')</label>
                        <input id="Thigh_size" type="text" placeholder="50 - 150" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/thigh_size.jpg';">
                        <span class="err_thigh_size"></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col_center my_custom_50">
                    <div class="group">
                        <label>@lang('messages.LENGTH_OF_SLEEVES')</label>
                        <input id="Length_of_sleeves" type="text" placeholder="1 - 75" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/length_of_sleeves.jpg';">
                        <span class="err_length_of_sleeves"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.GIRTH_OF_THE_FOREARM')</label>
                        <input id="Girth_of_the_forearm" type="text" placeholder="10 - 60" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/girth_of_the_forearm.jpg';">
                        <span class="err_girth_of_the_forearm"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.LENGTH_OF_THE_LOOP_FROM_THE_WAIST')</label>
                        <input id="Length_of_the_loop_from_the_waist" type="text" placeholder="150 - 250" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/length_of_the_loop_from_the_waist.jpg';">
                        <span class="err_length_of_the_loop_from_the_waist"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.FROM_WAIST_TO_FLOOR')</label>
                        <input id="From_waist_to_floor" type="text" placeholder="100 - 150" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/from_waist_to_floor.jpg';">
                        <span class="err_from_waist_to_floor"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.LENGTH_SIDE_SEAM')</label>
                        <input id="Length_of_the_product_along_the_side_seam" type="text" placeholder="100 - 150" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/length_of_the_product_along_the_side_seam.jpg';">
                        <span class="err_length_of_the_product_along_the_side_seam"></span>
                    </div>
                    <div class="group">
                        <label>@lang('messages.HEIGHT_ON_HEELS')</label>
                        <input id="Height_on_heels" type="text" placeholder="100 - 250" value="" onfocus="document.getElementById('dinamic').src = '/images/individual_size/height_on_heels.jpg';">
                        <span class="err_height_on_heels"></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_center my_custom_100">
                    <div class="dinamic_img">
                        <img src="" alt="" id="dinamic">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input onclick="addToCartInd()" type="submit" value="@lang('messages.SUBMIT')">
            </div>
        </div>

    </div>
</div>
