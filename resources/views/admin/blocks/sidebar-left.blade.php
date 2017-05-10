<!-- sidebar left start-->
<div class="sidebar-left">

    <div class="sidebar-left-info">
        <!-- visible small devices start-->
        <div class=" search-field">  </div>
        <!-- visible small devices end-->

        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked side-navigation">
            <li >
                <a href="{{ url(App::getLocale().'/admin/dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span>Управление</span>
                </a>
            </li>
            @if( Auth::User()->hasRole('Owner') )
                <li class="menu-list">
                    <a href="#"><i class="fa fa-money"></i>
                        <span>Отчеты по клиентам</span></a>
                    <ul class="child-list">
                        <li><a href="{{ url(App::getLocale().'/admin/finance/clients/general-stat') }}">Общая статистика</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/finance/clients/deposits') }}">Пополнения</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/finance/clients/expenses') }}">Траты</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/finance/clients/refunds') }}">Возвраты</a></li>
                    </ul>
                </li>
                <li class="menu-list">
                    <a href="#"><i class="fa fa-money"></i>
                        <span>Отчеты по партнерам</span></a>
                    <ul class="child-list">
                        <li><a href="{{ url(App::getLocale().'/admin/finance/partners/general-stat') }}">Общая статистика</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/finance/partners/fines') }}">Штрафы</a></li>
                    </ul>
                </li>
                <li class="menu-list">
                    <a href="#"><i class="fa fa-usd"></i>
                        <span>Прайсы и курсы</span></a>
                    <ul class="child-list">
                        <li><a href="{{ url(App::getLocale().'/admin/finance/prices') }}">Прайсы на услуги</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/finance/rates') }}">Курсы и комиссии</a></li>
                    </ul>
                </li>
            @endif
            <li class="">
                <h3 class="navigation-title">Профили</h3>
            </li>
            @if( Auth::User()->hasRole('Owner') )
                <li class="menu-list">
                    <a href=""><i class="fa fa-user-secret"></i>
                        <span>Партнеры</span></a>
                    <ul class="child-list">
                        <li><a href="{{ url(App::getLocale().'/admin/partners/') }}">Все партнеры</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/partner/new') }}">Добавить партнера</a></li>
                    </ul>
                </li>
                <li class="menu-list">
                    <a href=""><i class="fa fa-user"></i>
                        <span>Модераторы</span></a>
                    <ul class="child-list">
                        <li><a href="{{ url(App::getLocale().'/admin/moderators') }}">Все модераторы</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/moderator/new') }}">Добавить модератора</a></li>
                    </ul>
                </li>
            @endif
            <li class="menu-list">
                <a href=""><i class="fa fa-female "></i>
                    <span>Девушки</span></a>
                <ul class="child-list">

                    <li><a href="{{ url(App::getLocale().'/admin/girls') }}">Все анкеты</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/girl/new') }}">Добавить анкету</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#check">Проверить анкету</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/girls/active') }}">Активные</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/girls/deactive') }}">Приостановленные</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/girls/dismiss') }}">Отклоненные</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/girls/deleted') }}">Удаленные</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/girls/onmoderation') }}">На модерации</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/girls/noprofile') }}">Не завершенные</a></li>
                </ul>
            </li>
            @if(Auth::User()->hasRole('Owner') || Auth::User()->hasRole('Moder'))
                <li class="menu-list">
                    <a href=""><i class="fa fa-male "></i>
                        <span>Мужчины</span></a>
                    <ul class="child-list">
                        <li><a href="{{ url(App::getLocale().'/admin/men') }}">Все анкеты</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/man/active') }}">Активные</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/man/deactive') }}">Приостановленные</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/man/dismiss') }}">Отклоненные</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/man/deleted') }}">Удаленные</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/man/onmoderation') }}">На модерации</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/man/noprofile') }}">Не завершенные</a></li>
                    </ul>
                </li>
            @endif
                <li>
                    <a href="{{ url(App::getLocale().'/admin/sender') }}"><i class="fa fa-envelope-o"></i>Рассылка</a>
                </li>

                <li class="menu-list">
                    <a href=""><i class="fa fa-gift"></i>
                        <span>Подарки</span></a>
                    <ul class="child-list">
                        <li><a href="{{ url(App::getLocale().'/admin/presents') }}">Список подарков</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/gifts/status/not_confirmed') }}">Не подтверждены</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/gifts/status/on_confirmation') }}">На рассмотрении</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/gifts/status/dismissed') }}">Отклонены</a></li>
                        <li><a href="{{ url(App::getLocale().'/admin/gifts/status/confirmed') }}">Подтверждены</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url(App::getLocale().'/admin/messages-from-man') }}"> <i class="fa fa-envelope-o"></i>Сообщения от мужчин</a>
                </li>
            <li>
                <a href="{{ url(App::getLocale().'/admin/support') }}"><i class="fa fa-life-ring"></i>Обратная связь</a>
            </li>
            @if( Auth::User()->hasRole('Owner') )
            <li>
                <h3 class="navigation-title">Контент</h3>
            </li>
            <li class="menu-list"><a href="javascript:;"><i class="fa fa-paper-plane"></i>
                    <span>Блог</span></a>
                <ul class="child-list">
                    <li><a href="{{ url(App::getLocale().'/admin/blog') }}">Все записи</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/blog/new') }}">Добавить запись</a></li>
                </ul>
            </li>
            <li class="menu-list"><a href="javascript:;"><i class="fa fa-file-text-o"></i>
                    <span>Страницы</span></a>
                <ul class="child-list">
                    <li><a href="{{ url(App::getLocale().'/admin/pages') }}">Все страницы</a></li>
                    <li><a href="{{ url(App::getLocale().'/admin/pages/add') }}">Добавить страницу</a></li>
                </ul>
            </li>
            <li class=""><a href="{{ url(App::getLocale().'/admin/horoscope') }}"><i class="fa fa-star-half-empty"></i>
                    <span>Гороскопы</span></a>
            </li>
            @endif()
            <li class=""><a href="{{ url(App::getLocale().'/admin/profile/') }}"><i class="fa fa-user-md"></i>
                    <span>Профиль</span></a>
            </li>
        </ul>
        <!--sidebar nav end-->
    </div>
</div>
<!-- sidebar left end-->