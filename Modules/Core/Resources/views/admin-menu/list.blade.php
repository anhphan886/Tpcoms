<div class="kt-section__content">
    <form id="form-filter" action="{{route('core.admin-menu.index')}}">
      <div class="table_responsive">
          <table class="table table-striped">
              <thead>
              <tr>
                  <th id="th_menu_name">
                      <p class="pn-pointer" onclick="adminMenu.sort(this, 'menu_name')"
                         data-sort="{{ ($filter['sort_admin_menu$menu_name'] == 'asc') ? 'desc' : 'asc' }}">
                          @lang('core::admin-menu.table.ADMIN_MENU_NAME')
                          @if (isset($_GET['sort_admin_menu$menu_name']) && $_GET['sort_admin_menu$menu_name'] != null)
                              <i class="fa {{ ($filter['sort_admin_menu$menu_name'] == 'asc') ? 'fa-sort-amount-up' : 'fa-sort-amount-down' }}"></i>
                          @endif
                      </p>
                  </th>
                  <th id="th_menu_category_name">
                      <p class="pn-pointer" onclick="adminMenu.sort(this, 'menu_category_name')"
                         data-sort="{{ ($filter['sort_admncat$menu_category_name'] == 'asc') ? 'desc' : 'asc' }}">
                          @lang('core::admin-menu.table.ADMIN_MENU_CATEGORY_NAME')
                          @if (isset($_GET['sort_admncat$menu_category_name']) && $_GET['sort_admncat$menu_category_name'] != null)
                              <i class="fa {{ ($filter['sort_admncat$menu_category_name'] == 'asc') ? 'fa-sort-amount-up' : 'fa-sort-amount-down' }}"></i>
                          @endif
                      </p>
                  </th>
                  <th id="th_menu_position">
                      <p class="pn-pointer" onclick="adminMenu.sort(this, 'menu_position')"
                         data-sort="{{ ($filter['sort_admin_menu$menu_position'] == 'asc') ? 'desc' : 'asc' }}">
                          @lang('core::admin-menu.table.ADMIN_MENU_POSITION')
                          @if (isset($_GET['sort_admin_menu$menu_position']) && $_GET['sort_admin_menu$menu_position'] != null)
                              <i class="fa {{ ($filter['sort_admin_menu$menu_position'] == 'asc') ? 'fa-sort-amount-up' : 'fa-sort-amount-down' }}"></i>
                          @endif
                      </p>
                  </th>
                  <th>
                      <p class="pn-pointer">
                          @lang('core::user.index.ACTION')
                      </p>
                  </th>
              </tr>
              </thead>
              <tbody>
              @if (isset($list) && $list->count() > 0)
                  @foreach ($list as $item)
                      <tr>
                          <td>
                              <a href="{{ route('core.admin-menu.show', ['id' => $item['menu_id']]) }}"
                                 title="{{ $item['menu_name'] }}">
                                  {{ subString($item['menu_name']) }}
                              </a>
                          </td>
                          <td>
                              <p title="{{ $item['menu_category_name'] }}">
                                  {{ subString($item['menu_category_name']) }}
                              </p>
                          </td>
                          <td>
                              <p title="{{ $item['menu_position'] }}">
                                  {{ subString($item['menu_position']) }}
                              </p>
                          </td>
                          <td>
                              <div class="kt-portlet__head-toolbar">
                                  <div class="btn-group" role="group">
                                      <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Hành động
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                          <a href="{{ route('core.admin-menu.show', ['id' => $item->menu_id]) }}" class="dropdown-item">
                                              <i class="la la-search"></i>
                                              <span class="kt-nav__link-text kt-margin-l-5">
                                            @lang('core::admin-menu.index.TABLE_VIEW')
                                        </span>
                                          </a>
                                          @include('helpers.button', ['button' => [
                                                      'route' => 'core.admin-menu.edit',
                                                       'html' => '<a href="'.route('core.admin-menu.edit', ['id' => $item->menu_id]).'" class="dropdown-item">'
                                                       .'<i class="la la-edit"></i>'
                                                       .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-menu.index.TABLE_EDIT').'</span>'.
                                                  '</a>'
                                              ]])
                                          @include('helpers.button', ['button' => [
                                                     'route' => 'core.admin-menu.destroy',
                                                      'html' => '<a href="javascript:void(0)" onclick="adminMenu.removeMenu('.$item->menu_id.')" class="dropdown-item">'
                                                      .'<i class="la la-trash"></i>'
                                                      .'<span class="kt-nav__link-text kt-margin-l-5">'
                                                          .__('core::admin-menu.index.TABLE_REMOVE').
                                                      '</span>'.
                                                 '</a>'
                                             ]])
                                      </div>
                                  </div>
                              </div>
                          </td>
                      </tr>
                  @endforeach
              @else
                  <tr>
                      <td colspan="12" class="text-center">
                          @lang('ticket::ticket.table.data_null')
                      </td>
                  </tr>
              @endif
              </tbody>
          </table>
      </div>
        <input type="hidden" name="sort_admin_menu$menu_name" value="{{$filter['sort_admin_menu$menu_name']}}"
               id="sort_menu_name">
        <input type="hidden" name="sort_admncat$menu_category_name" value="{{$filter['sort_admncat$menu_category_name']}}"
               id="sort_menu_category_name">
        <input type="hidden" name="sort_admin_menu$menu_position" value="{{$filter['sort_admin_menu$menu_position']}}"
               id="sort_menu_position">
    </form>
    {{$list->appends($filter)->links('helpers.paging')}}
</div>
