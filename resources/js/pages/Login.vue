<script>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import axios from "axios";

export default {
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        GuestLayout
    },
    data() {
        return {
            form: {
                email: "",
                password: "",
                errors: {
                },
                processing: false
            }
        }
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/login', this.form)

                const { redirect_url } = response.data.data;

                window.location.href = redirect_url;
            } catch(error) {
                if(error.response.status == 422) {
                    const { errors } = error.response.data.data
                    this.form.errors = errors
                }
            }
        }
    }
}
</script>

<template>
    <GuestLayout>

        <form @submit.prevent="login">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" v-if="form.errors.email"  :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" v-if="form.errors.password" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
