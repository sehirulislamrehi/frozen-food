<div class="br-header">
     <div class="br-header-left">
          <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
          <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
          
     </div>
     <div class="br-header-right">
          <nav class="nav">
               
               <div class="dropdown">
                    <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                         <span class="logged-name hidden-md-down">
                              @if( auth('super_admin')->check() )
                                   {{ auth('super_admin')->user()->name }}
                              @elseif( auth('web')->check() )
                                  {{ auth('web')->user()->name }}
                              @endif
                         </span>
                         <img 
                              @if(auth('super_admin')->check())
                                   @if(auth('super_admin')->user()->image == null )
                                        src="{{ asset('images/profile/user.png') }}"
                                   @else
                                        src="{{ asset('images/profile/'.auth('super_admin')->user()->image ) }}"
                                   @endif
                              @elseif(auth('web')->check())
                                   @if(auth('web')->user()->image == null )
                                        src="{{ asset('images/profile/user.png') }}"
                                   @else
                                        src="{{ asset('images/profile/'.auth('web')->user()->image ) }}"
                                   @endif
                              @endif
                         class="wd-32 rounded-circle" alt="">
                         <span class="square-10 bg-success"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-header wd-250">
                         <ul class="list-unstyled user-profile-nav">
                              <li>
                                   <a
                                        @if( auth('super_admin')->check() )
                                             href="{{ route('profile.show',auth('super_admin')->user()->email) }}"
                                        @elseif( auth('web')->check() )
                                             href="{{ route('profile.show',auth('web')->user()->staff_id) }}"
                                        @endif
                                   >
                                   <i class="icon ion-ios-person"></i> Edit Profile</a>
                              </li>
                              <li>
                                   <a href="#" onclick="document.getElementById('logout-form').submit()">
                                        <i class="icon ion-power"></i> 
                                        Sign Out
                                        <form action="{{route('do.logout')}}" method="post" id="logout-form">@csrf</form>
                                   </a>
                              </li>
                         </ul>
                    </div>
               </div>
          </nav>
     </div>
</div>