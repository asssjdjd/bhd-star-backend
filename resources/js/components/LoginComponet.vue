<template>
  <div class="wrapper">
    <!-- Banner -->
    <div id="top-banner">
       <img src="/asset/img/Ngang-02.jpg" alt="header" width="100%" height="125px" />
    </div>

    <!-- Main Content -->
    <hr style="border: 1px solid #72be43; margin-left: 5%; margin-right: 5%; margin-top: 0px;" />
    <div class="main mt-3">
      <div class="container-fluid d-flex row" style="width: 100%;">
        <div class="form-register col-5">
          <LoginForm />
        </div>
        <div class="form-login col-7">
          <RegisterForm />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoginForm from './LoginForm.vue';
import RegisterForm from './RegisterForm.vue';

export default {
  name: 'App',
  components: {
    LoginForm,
    RegisterForm,
  },
};
</script>

<style>
/* Scoped styles can be added here if needed */
</style>