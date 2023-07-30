<script>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import VueMultiselect from 'vue-multiselect'

export default {
    mounted() {
        console.log(this.$attrs.genres)
    },
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        GuestLayout,
        VueMultiselect
    },
    data() {
        return {
            genres: [],
            form: {
                name: "",
                country: "",
                genres: [],
                errors: {
                },
                processing: false
            }
        }
    },
    watch: {
        genres(newValues) {
            this.form.genres = newValues.map(item => item.id);
        },
    },
    methods: {
        async addFilm() {
            try {
                this.form.processing = true;

                const response = await axios.post(`/api/v1/films`, this.form, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })

                const responseData = response.data.data;

                this.$notify({
                    title: "Success",
                    text: response.data.message,
                    type: 'success'
                });

                window.location.href = `/films/${responseData.slug}`

            } catch (error) {
                if (error.response.status == 422) {
                    const { errors } = error.response.data.data
                    this.form.errors = errors
                } else {
                    this.$notify({
                        title: "Error",
                        text: "Something went wrong",
                        type: 'error'
                    });
                }
            } finally {
                this.form.processing = false;
            }
        },

        handleFileChange(e) {
            this.form.photo = e.target.files[0];
        }
    }
}
</script>

<template>
    <GuestLayout>
        <form @submit.prevent="addFilm" enctype="multipart/form-data">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" />

                <InputError class="mt-2" v-if="form.errors.name" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="Description" />

                <textarea
                    class="form-input h-20 resize-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                    v-model="form.description">
                </textarea>

                <InputError class="mt-2" v-if="form.errors.description" :message="form.errors.description" />
            </div>

            <div class="mt-4">
                <InputLabel for="release_date" value="Release Date" />

                <TextInput id="release_date" type="date" class="mt-1 block w-full" v-model="form.release_date" required />

                <InputError class="mt-2" v-if="form.errors.release_date" :message="form.errors.release_date" />
            </div>

            <div class="mt-4">
                <InputLabel for="rating" value="Rating" />

                <TextInput min="1" max="5" step=".1" id="rating" type="number" class="mt-1 block w-full"
                    v-model="form.rating" required />

                <InputError class="mt-2" v-if="form.errors.rating" :message="form.errors.rating" />
            </div>

            <div class="mt-4">
                <InputLabel for="ticket_price" value="Ticket Price" />

                <TextInput min="1" step=".01" id="ticket_price" type="number" class="mt-1 block w-full"
                    v-model="form.ticket_price" required />

                <InputError class="mt-2" v-if="form.errors.ticket_price" :message="form.errors.ticket_price" />
            </div>

            <div class="mt-4">
                <InputLabel for="genres" value="Genres" />

                <VueMultiselect v-model="genres" :options="$attrs.genres" :multiple="true" :close-on-select="true"
                    placeholder="Select Single or Mutiple" label="name" track-by="id" required />
                <!-- <select
                    id="genres"
                    class="form-input border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                    v-model="form.genres"
                    required
                    multiple
                >
                    <option value="">Select Genres</option>
                    <option
                        v-for="genre in this.$attrs.genres"
                        :key="genre.id"
                        :value="genre.id"
                    >
                        {{ genre.name }}
                    </option>
                </select> -->

                <InputError class="mt-2" v-if="form.errors.genres" :message="form.errors.genres" />
            </div>

            <div class="mt-4">
                <InputLabel for="country" value="Country" />

                <select id="ticket_price"
                    class="form-input border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                    v-model="form.country" required>
                    <option value="">Select Country</option>
                    <option value="USA">USA</option>
                    <option value="UK">UK</option>
                </select>

                <InputError class="mt-2" v-if="form.errors.country" :message="form.errors.country" />
            </div>


            <div class="mt-4">
                <InputLabel for="photo" value="Film Poster" />

                <TextInput id="photo" type="file" class="form-input mt-1 block w-full border border-gray-300"
                    @change="handleFileChange" required />

                <InputError class="mt-2" v-if="form.errors.photo" :message="form.errors.photo" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
