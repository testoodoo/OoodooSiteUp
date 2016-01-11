<aside class="profile-nav col-lg-3">
    <section class="panel">
        <div class="user-heading round">
            <a href="#">
                @if ($user->gender == "m")
                    <img src="/assets/dist/user/img/default_male.jpg" alt="">
                @else
                    <img src="/assets/dist/user/img/default_female.jpg" alt="">
                @endif
            </a>
            <h1>{{$user->first_name}} {{$user->last_name}}</h1>
            <p>{{$user->email}}</p>
        </div>
        <ul class="nav nav-pills nav-stacked">
            <li class=<?= Request::path() == "profile" ? "active" : "" ?>>
                <a href="/profile">
                    <i class="icon-user"></i> Profile
                </a>
            </li>
            <li class=<?= Request::path() == "users/change-password" ? "active" : "" ?>>
                <a href="/users/change-password"> 
                    <i class="icon-lock"></i> Change Password
                </a>
            </li>
            <li class=<?= Request::path() == "users/edit" ? "active" : "" ?>>
                <a href="/users/edit"> 
                    <i class="icon-edit"></i> Edit profile
                </a>
            </li>
        </ul>
      </section>
</aside>