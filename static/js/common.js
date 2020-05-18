const getCookie = function (name) {
    let arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
};

const setCookie = function (c_name, value, expiredays) {
    let exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" + escape(value) +
        ((expiredays === null) ? "" : ";expires=" + exdate.toGMTString())
};

const checkResp = function (resp, successCallback = null, errorCallback = null) {
    if (resp.body.msg === 'ok') {
        if (successCallback !== null){
            successCallback()
        }
        alert("操作成功");
    }else {
        if (errorCallback !== null){
            errorCallback()
        }
        alert(resp.body.msg === undefined ? resp.body : resp.body.msg);
    }
};

Vue.http.options.emulateJSON = true;
const api = Vue.resource('http://127.0.0.1/tickets_system/api/api.php?action={action}');

// 登录模块
//
Vue.component('my-login', {
    template: `
    <!-- Login Modal -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="float: left" class="modal-title">您尚未登录</h4>
                    <div style="float: right;" class="btn-group" data-toggle="buttons">
                        <label class="btn btn-success active" @click="changeSignIn()">
                            <input type="radio" name="options" id="signIn" autocomplete="off" checked>登录
                        </label>
                        <label class="btn btn-warning" @click="changeSignUp()" >
                            <input type="radio" name="options" id="signUp" autocomplete="off">注册
                        </label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="signIn" :class="{hidden: isSignInHidden}">
                        <div style="margin-top: 10px" class="input-group">
                            <span class="input-group-addon">用户名</span>
                            <input type="text" v-model="signInForm.account" name="account" class="form-control" placeholder="Account">
                        </div>
                        <div style="margin-top: 10px" class="input-group">
                            <span class="input-group-addon">密码</span>
                            <input type="password" v-model="signInForm.password" name="password" class="form-control" placeholder="Password">
                        </div>
                          <div class="label label-danger">{{ signInForm.errorMsg }}</div>
                        <div style="margin-top: 20px" @click="doSignIn" class="btn btn-primary btn-block">登录</div>
                    </div>
                    <div class="signUp"  :class="{hidden: isSignUpHidden}">
                        <div style="margin-top: 10px" class="input-group">
                            <span class="input-group-addon">用户名</span>
                            <input type="text" v-model="signUpForm.account" name="account" class="form-control" placeholder="Account">
                        </div>
                        <div style="margin-top: 10px" class="input-group">
                            <span class="input-group-addon">密码</span>
                            <input type="password"  v-model="signUpForm.password"  name="password" class="form-control" placeholder="Password">
                        </div>
                        <div style="margin-top: 10px" class="input-group">
                            <span class="input-group-addon">重复密码</span>
                            <input type="password"  v-model="signUpForm.password2"  name="password2" class="form-control" placeholder="Password">
                        </div>
                        <div style="margin-top: 10px" class="input-group">
                            <span class="input-group-addon">个人姓名</span>
                            <input type="text"  v-model="signUpForm.pName"  name="p_name" class="form-control" placeholder="Name">
                        </div>
                        <div style="margin-top: 10px" class="input-group">
                            <span class="input-group-addon">身份证号</span>
                            <input type="text"  v-model="signUpForm.pId"  name="p_id" class="form-control" placeholder="Personal ID">
                        </div>
                        <div class="label label-danger">{{ signUpForm.errorMsg }}</div>
                        <div style="margin-top: 20px" @click="doSignUp" class="btn btn-primary btn-block">注册</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `,
    data: function () {
        return {
            isSignUpHidden: true,
            isSignInHidden: false,
            signInForm: {
                account: '',
                password: '',
                errorMsg: ''
            },
            signUpForm: {
                account: '',
                password: '',
                password2: '',
                pName: '',
                pId: '',
                errorMsg: ''
            }
        }
    },
    mounted: function () {
        this.checkLogin();
    },
    methods: {
        checkLogin: function () {
            this.userId = getCookie('userId');
            if (this.userId !== null && this.userId !== 0 && this.userId !== "0" && this.userId !== "") {
                return;
            }
            $("#login").modal({
                backdrop: false
            })
        },
        changeSignUp: function () {
            this.isSignUpHidden = false;
            this.isSignInHidden = true;
        },
        changeSignIn: function () {
            this.isSignUpHidden = true;
            this.isSignInHidden = false;
        },
        doSignIn: function () {
            if (this.signInForm.account === ''){
                this.signInForm.errorMsg = "帐号输入不能为空";
            }

            api.save({action: 'sign_in'},
                this.signInForm
            ).then(resp => {
                checkResp(resp, () => {
                    setCookie("userId", resp.body.uid);
                    $("#login").modal('hide')
                })
            });
        },
        doSignUp: function () {
            if (this.signUpForm.account === '' || this.signUpForm.account === '' || this.signUpForm.account === '' || this.signUpForm.account === ''){
                this.signUpForm.errorMsg = "输入框内的任何一项均不能为空！";
                return ;
            }
            if (this.signUpForm.password !== this.signUpForm.password2){
                this.signUpForm.errorMsg = "两次密码填入的不一致";
                return ;
            }
            api.save({action: 'sign_up'},
                this.signUpForm
            ).then(resp => {
                checkResp(resp, () => {
                    location.reload();
                })
            })
        }
    }
});

