<script>
import GuestLayout from '@/layouts/GuestLayout.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import Spinner from '@/components/Spinner.vue';
import FilmCard from '@/components/FilmCard.vue';
import Comments from '@/components/Comments.vue';
import axios from "axios";

export default {
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        GuestLayout,
        Spinner,
        FilmCard,
        Comments
    },
    async mounted() {
        await this.fetchFilm();
    },
    props: {
        slug: {
            type: String,
            required: true
        },
        user: {
            type: Object,
            default: null
        },
    },
    data() {
        return {
            film: null,
            processing: true
        }
    },
    methods: {
        async fetchFilm() {
            try {
                const response = await axios.get(`/api/v1/films/${this.slug}`)
                const responseData = response.data.data

                this.film = responseData.film;

                console.log(response, 33)
            } catch (error) {
                alert("Something went wrong")
            }

            this.processing = false;
        }
    }
}
</script>

<template>
    <GuestLayout>
        <film-card v-if="film" :film="film"></film-card>

        <comments
            v-if="film"
            v-bind="user && {user}"
            :comments="film.comments"
            :slug="`${film.slug}`"
        ></comments>

        <div class="text-center text-xl font-semibold text-rose-500" v-else-if="!processing && !film">
            Film Not found
        </div>

        <div v-if="processing">
            <Spinner></Spinner>
        </div>

    </GuestLayout>
</template>
