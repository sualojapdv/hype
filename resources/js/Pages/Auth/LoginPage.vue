<template>
    <AuthLayout>
        <div v-if="!isLoading" class="my-auto mt-36">
            <div class="px-4 py-5">
                <div class="min-h-[calc(100vh-565px)] text-center flex flex-col items-center justify-center">
                    <div class="w-full rounded-lg shadow-lg border-none md:mt-0 sm:max-w-md xl:p-0" style="background-color: var(--ci-primary-color)">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="mb-8 text-3xl text-center">
                                {{ $t("Login") }}
                            </h1>
                            <div class="mt-4 px-4" style="background-color: var(--ci-primary-color);">
                                <form @submit.prevent="loginSubmit" method="post" action="" class="">
                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-regular fa-phone text-success-emphasis"></i>
                                        </div>
                                        <input required type="text" v-model="loginForm.phone" name="phone" class="input" v-maska data-maska="[
                                            '(##) ####-####',
                                            '(##) #####-####'
                                          ]" placeholder="Digite seu telefone" style="
                                                background: var(--ci-secundary-color);
                                                color: var(--ci-gray-dark);
                                                border: 1px solid var(--ci-secundary-color);
                                                padding-left: 2.5rem;
                                            " />
                                    </div>

                                    <div class="relative mb-6">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-regular fa-lock text-success-emphasis"></i>
                                        </div>
                                        <input required :type="typeInputPassword" v-model="loginForm.password" name="password" class="input pr-[40px]" :placeholder="$t('Type the password')" style="
                                                background: var(--ci-secundary-color);
                                                color: var(--ci-gray-dark);
                                                border: 1px solid var(--ci-secundary-color);
                                                padding-left: 2.5rem;
                                            " />
                                        <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5">
                                            <i v-if="typeInputPassword === 'password'" class="fa-regular fa-eye"></i>
                                            <i v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"></i>
                                        </button>
                                    </div>
                                    <a @click.prevent="$router.push('/forgot-password')" href="" class="text-white text-sm">{{ $t("Forgot password") }}</a>

                                    <div class="mt-3 w-full">
                                        <button type="submit" class="ui-button-blue rounded w-full mb-3">
                                            {{ $t("Log in") }}
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-300 mb-6">
                                        {{ $t("Not have an account yet") }}?
                                        <RouterLink :to="{ name: 'register' }" active-class="top-register-active" class="">
                                            <strong>{{ $t("Create an account") }}</strong>
                                        </RouterLink>
                                    </p>
                                </form>

                                <div class="login-wrap mt-5">
                                    <div class="line-text">
                                        <div class="l"></div>
                                        <div class="t">
                                            Outros métodos de início de sessão
                                        </div>
                                        <div class="l"></div>
                                    </div>

                                    <div class="social-group mt-3">
                                        <a :href="redirectSocialTo()" class="text-social-button focus:ring-4 focus:outline-none font-medium text-sm px-5 py-2.5 text-center mr-2 mb-2" style="font-size: 1.4rem">
                                            <i class="fa-brands fa-google"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<script>
import { useToast } from "vue-toastification";
import { useAuthStore } from "@/Stores/Auth.js";
import HttpApi from "@/Services/HttpApi.js";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { useRouter } from "vue-router";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";

export default {
    props: [],
    components: { LoadingComponent, AuthLayout },
    data() {
        return {
            isLoading: false,
            typeInputPassword: "password",
            isReferral: false,
            loginForm: {
                phone: "",
                email: "",
                password: "",
            },
        };
    },
    setup(props) {
        const router = useRouter();
        return {
            router,
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
        if (this.isAuthenticated) {
            router.push({ name: "home" });
        }
    },
    methods: {
        redirectSocialTo: function () {
            return "/auth/redirect/google";
        },
        loginToggle: function () {
            this.modalAuth.toggle();
        },
        loginSubmit: async function (event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;
            const authStore = useAuthStore();

            // Concatenar o @gmail.com ao telefone digitado
            _this.loginForm.email = `${_this.loginForm.phone.replace(/[^0-9]/g, '')}@gmail.com`;

            await HttpApi.post("auth/login", {
                email: _this.loginForm.email,
                password: _this.loginForm.password
            })
                .then(async (response) => {
                    await new Promise((r) => {
                        setTimeout(() => {
                            authStore.setToken(response.data.access_token);
                            authStore.setUser(response.data.user);
                            authStore.setIsAuth(true);

                            _this.loginForm = {
                                phone: "",
                                email: "",
                                password: "",
                            };

                            _this.router.push({ name: "home" });
                            _toast.success(
                                _this.$t(
                                    "You have been authenticated, welcome!"
                                )
                            );

                            _this.isLoading = false;
                        }, 1000);
                    });
                })
                .catch((error) => {
                    const _this = this;
                    Object.entries(
                        JSON.parse(error.request.responseText)
                    ).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
        togglePassword: function () {
            if (this.typeInputPassword === "password") {
                this.typeInputPassword = "text";
            } else {
                this.typeInputPassword = "password";
            }
        },
    },
    watch: {},
};
</script>

<style scoped></style>
