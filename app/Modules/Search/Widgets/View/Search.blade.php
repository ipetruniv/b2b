{{ Form::open(array('url' => array('/'.(App::getLocale()).'/search'),'method'=>'get')) }}

    <input type="search" name="product" class="" id="search" placeholder="Seach" >

{{ Form::close() }}
