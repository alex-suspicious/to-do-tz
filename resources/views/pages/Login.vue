<!--Login.vue-->
<template>

<div class="w-100 row m-0" >
    <div class="col-lg-2 form-signin mx-auto" style="margin-top: calc(50vh - 250px);">
        <form method="post" @submit.prevent="handleLogin" >
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
              <input type="login" class="form-control" placeholder="login" id="login" v-model="form.login" required>
              <label for="login">Login</label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control" placeholder="Password" id="password" v-model="form.password" required>
              <label for="password">Password</label>
            </div>
            <br>
            <button class="btn btn-primary w-100" type="submit">Sign in</button>
        </form>
    </div>
</div>

</template>
<script>
    import { ref, reactive } from 'vue';
    import { useRouter } from 'vue-router';
    import axios from 'axios';

    export default {
        setup() {
            const errors = ref()
            const router = useRouter();
            const form = reactive({
                login: '',
                password: '',
            })
            const handleLogin = async () => {
                try {
                    const result = await axios.post('/auth/login', form)
                    if (result.status === 200 && result.data && result.data.access_token) {
                        localStorage.setItem('USER_TOKEN', result.data.access_token)
                        await router.push('/')
                    }
                } catch (e) {
                    console.log(e);
                }
            }

            return {
                form,
                errors,
                handleLogin,
            }
        }
    }
</script>