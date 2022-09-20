<div class="br-logo">
     <a href="{{ route('dashboard') }}">
          @if($app_info)
               <img src="{{ asset('images/info/'.$app_info->logo) }}" style="width: 100%;" alt="User Image">
          @endif
     </a>
</div>
<div class="br-sideleft sideleft-scrollbar">
     <label class="sidebar-label pd-x-10 mg-t-20 op-3"></label>
     <ul class="br-sideleft-menu">

          <!-- dashboard -->
          <li class="br-menu-item">
               <a href="{{ route('dashboard') }}" 
               @if(  Route::currentRouteName() == 'dashboard' )
                    class="br-menu-link active"
               @else
                    class="br-menu-link"
               @endif
               >
                    <i class="menu-item-icon fas fa-tachometer-alt"></i>
                    <span class="menu-item-label">Dashboard</span>
               </a>
          </li>

          @if( auth('super_admin')->check() )
               @foreach( App\Models\UserModule\Module::orderBy('position','asc')->get() as $module )
                    @if( $module->route == null )
                         <li class="br-menu-item">
                              <a href="#" class="br-menu-link with-sub">
                                   <i class="menu-item-icon {{ $module->icon }}"></i>
                                   <span class="menu-item-label">{{ $module->name }}</span>
                              </a>
                              <ul class="br-menu-sub">
                                   @foreach( $module->sub_module->sortBy('position',false) as $sub_module )
                                        <li class="sub-item">
                                             <a href="{{ route($sub_module->route) }}" 
                                             @if(  Route::currentRouteName() == $sub_module->route )
                                                  class="sub-link active"
                                             @else
                                                  class="sub-link"
                                             @endif
                                             >{{ $sub_module->name }} </a>
                                        </li>
                                   @endforeach
                              </ul>
                         </li>
                    @else
                         <li class="br-menu-item">
                              <a href="{{ route($module->route) }}" 
                              @if(  Route::currentRouteName() == $module->route )
                                   class="br-menu-link active"
                              @else
                                   class="br-menu-link"
                              @endif
                              >
                                   <i class="menu-item-icon {{ $module->icon }}"></i>
                                   <span class="menu-item-label">{{ $module->name }}</span>
                              </a>
                         </li>
                    @endif
               @endforeach
          @elseif( auth('web')->check() )
               @foreach( App\Models\UserModule\Module::orderBy('position','asc')->get() as $module )
                    @if( can($module->key) )
                         @if( $module->route == null )
                              <li class="br-menu-item">
                                   <a href="#" class="br-menu-link with-sub">
                                        <i class="menu-item-icon {{ $module->icon }}"></i>
                                        <span class="menu-item-label">{{ $module->name }}</span>
                                   </a>
                                   <ul class="br-menu-sub">
                                        @foreach( $module->sub_module->sortBy('position',false) as $sub_module )
                                             @if( can($sub_module->key) )
                                             <li class="sub-item">
                                                  <a href="{{ route($sub_module->route) }}" 
                                                  @if(  Route::currentRouteName() == $sub_module->route )
                                                       class="sub-link active"
                                                  @else
                                                       class="sub-link"
                                                  @endif
                                                  >{{ $sub_module->name }} </a>
                                             </li>
                                             @endif
                                        @endforeach
                                   </ul>
                              </li>
                         @else
                              <li class="br-menu-item">
                                   <a href="{{ route($module->route) }}" 
                                   @if(  Route::currentRouteName() == $module->route )
                                        class="br-menu-link active"
                                   @else
                                        class="br-menu-link"
                                   @endif
                                   >
                                        <i class="menu-item-icon {{ $module->icon }}"></i>
                                        <span class="menu-item-label">{{ $module->name }}</span>
                                   </a>
                              </li>
                         @endif
                    @endif
               @endforeach
          @endif

          
     </ul>

</div>