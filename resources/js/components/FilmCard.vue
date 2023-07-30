<script>

export default {
    props: {
        film: {
            type: Object,
            required: true
        },
        link: Boolean
    }
}
</script>

<template>
    <div class="flex flex-col rounded-lg border-2 border-blue-300 md:max-w-xl md:flex-row">
        <img class="border-2 border-r-blue-300 h-96 w-full rounded-t-lg object-cover md:h-auto md:w-48 md:rounded-none md:rounded-l-lg"
            :src="film.photo" :alt="film.name" />
        <div class="flex flex-col justify-start p-6">
            <h5 class="text-gray-700 text-xl font-medium">
                <a v-if="link" :href="`/films/${film.slug}`" class="hover:underline hover:text-indigo-500">
                    {{ film.name }} ({{ new Date(film.release_date).getFullYear() }})
                </a>
                <span v-else>
                    {{ film.name }} ({{ new Date(film.release_date).getFullYear() }})
                </span>
            </h5>
            <p class="text-xs text-gray-500 mb-2">
                <span class="text-blue-500" v-for="genre in film.genres" :key="genre.name">
                    <b>{{ genre.name }}</b>&nbsp;
                </span>
            </p>
            <p class="mb-4 text-base text-gray-500">
                {{ film.description }}
            </p>
            <p class="text-base text-gray-500">
                Rating: <b>{{ film.rating }}</b>
            </p>
            <p class="text-base text-gray-500">
                Ticket: <b>${{ film.ticket_price }}</b>
            </p>
        </div>
    </div>
</template>
