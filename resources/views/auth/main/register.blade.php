<div>
    <main class="main-container">
        <div class="left-section">

        </div>
        <div class="register-section">
            <div class="create-account">
                <h1>Create a New Account</h1>
                <h4>It's quick and easy.</h4>
            </div>

            <div class="register-account">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
    
                    <div class="form-group form-name">
                        <div class="input-container">
                            <input placeholder="First name" type="text" class="@error('first_name')invalid-red-border @enderror" name="first_name" value="{{ old('first_name') }}"  autocomplete="first_name" autofocus>
                            @error('first_name')
                                <div class="invalid">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                        width="100%" height="100%"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#fff"><path d="M70.83802,17.2l2.46354,91.73333h25.30729l2.55312,-91.73333zM86.04479,126.13333c-9.41986,0 -15.29635,5.46853 -15.29635,14.37812c0,8.82934 5.88222,14.28854 15.29635,14.28854c9.41413,0 15.21797,-5.45921 15.21797,-14.28854c0,-8.90959 -5.7981,-14.37812 -15.21797,-14.37812z"></path></g></g></svg>
                                </div>
                                <div class="focus-warning">
                                    <p>What's your name?</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="arrow-to-right"
                                        width="24" height="24"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#be4b49"><path d="M34.4,17.2c-3.16643,0 -5.73333,2.5669 -5.73333,5.73333c-0.00001,0.00747 -0.00001,0.01493 0,0.0224v63.04427v63.04427c-0.00001,0.00746 -0.00001,0.01493 0,0.02239c0,3.16643 2.5669,5.73333 5.73333,5.73333c1.19346,-0.00345 2.3561,-0.37925 3.32578,-1.075l0.0112,0.0112l113.71485,-62.52917c2.03773,-0.93223 3.34559,-2.96619 3.34817,-5.20703c0.00115,-2.30642 -1.37987,-4.38898 -3.50495,-5.28542l-113.55807,-62.45078h-0.0112c-0.97102,-0.69177 -2.13354,-1.06362 -3.32578,-1.0638z"></path></g></g></svg>
                                </div>
                            @enderror
                        </div>

                        <div class="input-container last-name-container">
                            <input placeholder="Last name" type="text" class="@error('last_name')invalid-red-border @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="last_name" autofocus>
                            @error('last_name')
                                <div class="invalid">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                        width="100%" height="100%"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#fff"><path d="M70.83802,17.2l2.46354,91.73333h25.30729l2.55312,-91.73333zM86.04479,126.13333c-9.41986,0 -15.29635,5.46853 -15.29635,14.37812c0,8.82934 5.88222,14.28854 15.29635,14.28854c9.41413,0 15.21797,-5.45921 15.21797,-14.28854c0,-8.90959 -5.7981,-14.37812 -15.21797,-14.37812z"></path></g></g></svg>
                                </div>
                                <div class="focus-warning">
                                    <p>What's your name?</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="arrow-to-right"
                                        width="24" height="24"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#be4b49"><path d="M34.4,17.2c-3.16643,0 -5.73333,2.5669 -5.73333,5.73333c-0.00001,0.00747 -0.00001,0.01493 0,0.0224v63.04427v63.04427c-0.00001,0.00746 -0.00001,0.01493 0,0.02239c0,3.16643 2.5669,5.73333 5.73333,5.73333c1.19346,-0.00345 2.3561,-0.37925 3.32578,-1.075l0.0112,0.0112l113.71485,-62.52917c2.03773,-0.93223 3.34559,-2.96619 3.34817,-5.20703c0.00115,-2.30642 -1.37987,-4.38898 -3.50495,-5.28542l-113.55807,-62.45078h-0.0112c-0.97102,-0.69177 -2.13354,-1.06362 -3.32578,-1.0638z"></path></g></g></svg>
                                </div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group">
                        <div class="input-container">
                            <input id="email" placeholder="Email" type="email" class="@error('email') invalid-red-border @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">
                            @error('email')
                                <div class="invalid">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                        width="100%" height="100%"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#fff"><path d="M70.83802,17.2l2.46354,91.73333h25.30729l2.55312,-91.73333zM86.04479,126.13333c-9.41986,0 -15.29635,5.46853 -15.29635,14.37812c0,8.82934 5.88222,14.28854 15.29635,14.28854c9.41413,0 15.21797,-5.45921 15.21797,-14.28854c0,-8.90959 -5.7981,-14.37812 -15.21797,-14.37812z"></path></g></g></svg>
                                </div>
                                <div class="focus-warning">
                                    <p>You'll need this to log in</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="arrow-to-right"
                                        width="24" height="24"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#be4b49"><path d="M34.4,17.2c-3.16643,0 -5.73333,2.5669 -5.73333,5.73333c-0.00001,0.00747 -0.00001,0.01493 0,0.0224v63.04427v63.04427c-0.00001,0.00746 -0.00001,0.01493 0,0.02239c0,3.16643 2.5669,5.73333 5.73333,5.73333c1.19346,-0.00345 2.3561,-0.37925 3.32578,-1.075l0.0112,0.0112l113.71485,-62.52917c2.03773,-0.93223 3.34559,-2.96619 3.34817,-5.20703c0.00115,-2.30642 -1.37987,-4.38898 -3.50495,-5.28542l-113.55807,-62.45078h-0.0112c-0.97102,-0.69177 -2.13354,-1.06362 -3.32578,-1.0638z"></path></g></g></svg>
                                </div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group">
                        <div class="input-container">
                            <input id="password" placeholder="New password" type="password" class="@error('password') invalid-red-border @enderror" name="password"  autocomplete="new-password">
                            @error('password')
                                <div class="invalid">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                        width="100%" height="100%"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#fff"><path d="M70.83802,17.2l2.46354,91.73333h25.30729l2.55312,-91.73333zM86.04479,126.13333c-9.41986,0 -15.29635,5.46853 -15.29635,14.37812c0,8.82934 5.88222,14.28854 15.29635,14.28854c9.41413,0 15.21797,-5.45921 15.21797,-14.28854c0,-8.90959 -5.7981,-14.37812 -15.21797,-14.37812z"></path></g></g></svg>
                                </div>
                                <div class="focus-warning">
                                    <p>Enter your password</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="arrow-to-right"
                                        width="24" height="24"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#be4b49"><path d="M34.4,17.2c-3.16643,0 -5.73333,2.5669 -5.73333,5.73333c-0.00001,0.00747 -0.00001,0.01493 0,0.0224v63.04427v63.04427c-0.00001,0.00746 -0.00001,0.01493 0,0.02239c0,3.16643 2.5669,5.73333 5.73333,5.73333c1.19346,-0.00345 2.3561,-0.37925 3.32578,-1.075l0.0112,0.0112l113.71485,-62.52917c2.03773,-0.93223 3.34559,-2.96619 3.34817,-5.20703c0.00115,-2.30642 -1.37987,-4.38898 -3.50495,-5.28542l-113.55807,-62.45078h-0.0112c-0.97102,-0.69177 -2.13354,-1.06362 -3.32578,-1.0638z"></path></g></g></svg>
                                </div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group form-birthday">
                        <h1>Birthday</h1>

                        <div class="date">
                            <div>
                                <select name="birthday[month]" id="month">
                                    <option disabled>Month</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                            <div>
                                <select name="birthday[day]" id="day-selection">
                                    <option disabled>Day</option>
                                </select>
                            </div>
                            <div>
                                <select name="birthday[year]" id="year-selection">
                                    <option disabled>Year</option>
                                </select>
                            </div>                          
                        </div>
                    </div>

                    <div class="form-gender">
                        <h1>Gender</h1>

                        <div class="gender input-container">
                            <label for="female" class="gender-border @error('gender')invalid-red-border @enderror">
                                <input id="female" type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="female">
                                <h2>Female</h2>
                            </label>
                            <label for="male" class="gender-border @error('gender')invalid-red-border @enderror">
                                <input id="male" type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="male">
                                <h2>Male</h2>
                            </label>
                            <label for="custom" class="gender-border custom @error('gender')invalid-red-border @enderror">
                                <input id="custom" type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="custom">
                                <h2>Custom</h2>
                            </label>
                            @error('gender')
                                <div class="invalid gender-invalid">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                        width="100%" height="100%"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#fff"><path d="M70.83802,17.2l2.46354,91.73333h25.30729l2.55312,-91.73333zM86.04479,126.13333c-9.41986,0 -15.29635,5.46853 -15.29635,14.37812c0,8.82934 5.88222,14.28854 15.29635,14.28854c9.41413,0 15.21797,-5.45921 15.21797,-14.28854c0,-8.90959 -5.7981,-14.37812 -15.21797,-14.37812z"></path></g></g></svg>
                                </div>
                                <div class="focus-warning">
                                    <p>What's your name?</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="arrow-to-right"
                                        width="24" height="24"
                                        viewBox="0 0 172 172"
                                        style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#be4b49"><path d="M34.4,17.2c-3.16643,0 -5.73333,2.5669 -5.73333,5.73333c-0.00001,0.00747 -0.00001,0.01493 0,0.0224v63.04427v63.04427c-0.00001,0.00746 -0.00001,0.01493 0,0.02239c0,3.16643 2.5669,5.73333 5.73333,5.73333c1.19346,-0.00345 2.3561,-0.37925 3.32578,-1.075l0.0112,0.0112l113.71485,-62.52917c2.03773,-0.93223 3.34559,-2.96619 3.34817,-5.20703c0.00115,-2.30642 -1.37987,-4.38898 -3.50495,-5.28542l-113.55807,-62.45078h-0.0112c-0.97102,-0.69177 -2.13354,-1.06362 -3.32578,-1.0638z"></path></g></g></svg>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-gender-optional">
                        <input id="gender_optional" placeholder="Gender (Optional)" type="text" class="@error('gender_optional') is-invalid @enderror" name="custom_gender"  autocomplete="gender_optional">
                    </div>
                    

                    <div class="lorem">
                        <p>
                            Lorem ipsum dolor sit amet. Fuga, perferendis commodi autem voluptatem impedit molestias illum placeat aut quos labore?
                        </p>
                    </div>
    
                    <div class="form-button">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Sign Up') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

