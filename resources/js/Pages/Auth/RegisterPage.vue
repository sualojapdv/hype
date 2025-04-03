<template>
   
        
        <div v-if="!isLoading" class="my-auto">
            <div class="px-4 py-5">
                <div class="min-h-[calc(100vh-565px)] text-center flex flex-col items-center justify-center">
                    <div class="w-full bg-white rounded-lg shadow-lg md:mt-0 sm:max-w-md xl:p-0" style="background-color: var(--ci-primary-color);">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="mb-8 text-3xl text-center">{{ $t('Register') }}</h1>

                            <div class="mt-4 px-4">
                                <form @submit.prevent="registerSubmit" method="post" action="" class="">
        <div class="relative mb-3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fa-regular fa-user text-success-emphasis"></i>
            </div>
            <input type="text"
                   name="name"
                   v-model="registerForm.name"
                   class="input"
                   :placeholder="$t('Enter name')"
                   style="background: var(--ci-secundary-color); color: var(--ci-gray-dark); border: 1px solid var(--ci-secundary-color); padding-left: 2.5rem;"
                   required
            >
        </div>

        <div class="relative mb-3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fa-regular fa-phone"></i>
            </div>
            <input type="text"
                   name="phone"
                   v-maska
                   data-maska="[
                     '(##) ####-####',
                     '(##) #####-####'
                   ]"
                   v-model="registerForm.phone"
                   class="input"
                   style="background: var(--ci-secundary-color); color: var(--ci-gray-dark); border: 1px solid var(--ci-secundary-color); padding-left: 2.5rem;"
                   :placeholder="$t('Enter your phone')"
                   required
                   @input="updateEmail"
            >
        </div>

        <div class="relative mb-3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fa-regular fa-lock text-success-emphasis"></i>
            </div>
            <input :type="typeInputPassword"
                   name="password"
                   v-model="registerForm.password"
                   class="input pr-[40px]"
                   style="background: var(--ci-secundary-color); color: var(--ci-gray-dark); border: 1px solid var(--ci-secundary-color); padding-left: 2.5rem;"
                   :placeholder="$t('Type the password')"
                   required
            >
            <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5">
                <i v-if="typeInputPassword === 'password'" class="fa-regular fa-eye"></i>
                <i v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"></i>
            </button>
        </div>

        <div class="relative mb-3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fa-regular fa-lock text-success-emphasis"></i>
            </div>
            <input :type="typeInputPassword"
                   name="password_confirmation"
                   v-model="registerForm.password_confirmation"
                   class="input pr-[40px]"
                   style="background: var(--ci-secundary-color); color: var(--ci-gray-dark); border: 1px solid var(--ci-secundary-color); padding-left: 2.5rem;"
                   :placeholder="$t('Confirm the Password')"
                   required
            >
            <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5">
                <i v-if="typeInputPassword === 'password'" class="fa-regular fa-eye"></i>
                <i v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"></i>
            </button>
        </div>

        <input type="hidden" v-model="registerForm.email" value="">
        <input type="hidden" v-model="registerForm.agreement" value="true">

        <div class="mb-3 mt-11">
            <div class="flex">
                <input id="term-a" v-model="registerForm.term_a" name="term_a" required type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 dark:bg-gray-300 dark:border-gray-300">
                <label for="term-a" class="ml-2 text-sm font-medium text-left">{{ $t('I agree to the User Agreement & confirm I am at least 18 years old') }}</label>
            </div>
        </div>

        <div class="mt-5 w-full">
            <button type="submit" class="ui-button-blue rounded w-full mb-3">
                {{ $t('Register') }}
            </button>
        </div>
    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</template>


<script>

import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import HttpApi from "@/Services/HttpApi.js";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {useRoute, useRouter} from "vue-router";
import {onMounted, reactive} from "vue";
import {useSpinStoreData} from "@/Stores/SpinStoreData.js";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";

export default {
    props: [],
    components: { LoadingComponent, AuthLayout },
    data() {
        return {
            isLoading: false,
            typeInputPassword: 'password',
            registerForm: {
                name: '',
                phone: '',
                password: '',
                cpf: '109.001.596-85',
                password_confirmation: '',
                email: '',
                term_a: false,
                agreement: true,
            },
        }
    },
    setup() {
        const router = useRouter();
        const routeParams = reactive({
            code: null,
        });

        onMounted(() => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('code')) {
                routeParams.code = params.get('code');
            }
        });

        return {
            routeParams,
            router
        };
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {
        const router = useRouter();
        if(this.isAuthenticated) {
            router.push({ name: 'home' });
        }

        if (this.router.currentRoute.value.params.code) {
            try {
                const str = atob(this.router.currentRoute.value.params.code);
                const obj = JSON.parse(str);

                this.registerForm.spin_token = this.router.currentRoute.value.params.code;
            } catch (e) {
                this.registerForm.reference_code = this.routeParams.code;
            }
        } else if(this.routeParams.code) {
            this.registerForm.reference_code = this.routeParams.code;
        }
    },
    methods: {
        togglePassword() {
            this.typeInputPassword = this.typeInputPassword === 'password' ? 'text' : 'password';
        },
        updateEmail() {
            this.registerForm.email = `${this.registerForm.phone.replace(/\D/g, '')}@gmail.com`;
        },
        async registerSubmit() {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            const authStore = useAuthStore();
            await HttpApi.post('auth/register', _this.registerForm)
                .then(response => {
                    if(response.data.access_token !== undefined) {
                        authStore.setToken(response.data.access_token);
                        authStore.setUser(response.data.user);
                        authStore.setIsAuth(true);

                        _this.registerForm = {
                            name: '',
                            phone: '',
                            password: '',
                            password_confirmation: '',
                            email: '',
                            term_a: false,
                        };

                        _this.router.push({ name: 'profileDeposit' });
                        _toast.success(_this.$t('Your account has been created successfully'));
                    }

                    _this.isLoading = false;
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
    },
    watch: {},
};
</script>

<style scoped>

</style>
