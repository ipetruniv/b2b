
      <div class="burger" id="burger" style="display: none"  data-id="cls" >
          <a class="burger">
              <span class="burger mybtn"></span>
              <span class="burger mybtn"></span>
              <span class="burger mybtn"></span>
              <span class="burger mybtn"></span>
          </a>
          <div class="mini-menu" id="short_menu" style="display: none">
              <ul>
                  @if($catalogs)
                  
                      @foreach($catalogs as $row)
                          <li class="sub">
                              @if($row->code_1c_parent ==  '00000000-0000-0000-0000-000000000000' && $row->child && $row->counts>0)
                                  <a href="">{{ $row->name }}</a> 
                                   @else 
                              @endif
                              
                              @if($row->child) 
                                  <ul>
                                      @foreach($row->child as $children) 
                                          @if($children->counts>0)
                                                <li><a href="/{{ Config::get('app.locale') }}/catalog/{{ $row->url }}/{{ $children->url }}">{{ $children->name }}</a></li>
                                          @else 
                                         
                                          @endif

                                          @endforeach
                                  </ul>
                              @endif
                          </li>     
                      @endforeach
                  @endif      
                 
              </ul>
          </div>
      </div>
 





