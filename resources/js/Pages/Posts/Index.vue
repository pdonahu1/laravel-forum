<template>
<AppLayout>
    <Container>
        
            <PageHeading v-text="selectedTopic ? selectedTopic.name : 'All Posts'"></PageHeading>
            <p v-if="selectedTopic" class="mt-1 text-gray-600 text-sm">{{ selectedTopic.description }}</p>

            <menu class="flex space-x-1 mt-3 overflow-x-auto pb-2 pt-1">
                <Pill :href="route('posts.index', { query: searchForm.query })" :filled="! selectedTopic">
                    All Posts</Pill>
                <li v-for="topic in topics" :key="topic.id" class="inline mt-3">

            <Pill :href="route('posts.index', { topic: topic.slug, query: searchForm.query })"

            :filled="topic.id === selectedTopic?.id">
                {{ topic.name }}
            </Pill>
            
                </li>
            </menu>

            <form @submit.prevent="search" class="mt-4">
                <div>
                    <InputLabel for="query">Search</InputLabel>
                    <div class="mt-1 flex space-x-2">
                        <TextInput v-model="searchForm.query" class="w-full" id="query" />
                        <SecondaryButton type="submit">Search</SecondaryButton>
                        <DangerButton v-if="searchForm.query" @click="clearSearch">Clear</DangerButton>
                    </div>
                </div>
            </form>
        
        <ul class="divide-y mt-4">
            <li 
            v-for="post in posts.data" 
            :key="post.id" 
            class="flex flex-col md:flex-row justify-between items-baseline py-4 px-2">

                <Link :href="post.routes.show" 
                class="group">
                <span class="font-bold text-lg group-hover:text-indigo-500">{{ post.title }}</span>
                <span class="block pt-1 text-sm text-gray-600"> {{ formattedData(post) }} by {{ post.user.name }}</span>
            </Link>
            
          </li>
        </ul>
        <Pagination :meta="posts" :only="['posts']" />
    </Container>
</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { formatDistance, parseISO } from "date-fns";
import { relativeDate } from "@/Utilities/date.js";
import { onMounted } from 'vue';
import PageHeading from '@/Components/PageHeading.vue';
import Pill from '@/Components/Pill.vue';


const props = defineProps(['posts', 'topics', 'selectedTopic', 'query']);  // ← Capture props!
const formattedData = (post) => formatDistance(parseISO(post.created_at), new Date());

const searchForm = useForm({
    query: props.query,
    page: 1,
});

const page = usePage();

const search = () => searchForm.get(page.url);

const clearSearch = () => {
    searchForm.query = '';
    search();
};

</script>
