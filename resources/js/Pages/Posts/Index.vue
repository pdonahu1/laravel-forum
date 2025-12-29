<template>
<AppLayout>
    <Container>
        
            <PageHeading v-text="selectedTopic ? selectedTopic.name : 'All Posts'"></PageHeading>
            <p v-if="selectedTopic" class="mt-1 text-gray-600 text-sm">{{ selectedTopic.description }}</p>

            <menu class="flex space-x-1 mt-3 overflow-x-auto pb-2 pt-1">
                <li><Pill :href="route('posts.index')" :filled="! selectedTopic">All Posts</Pill></li>
                <li v-for="topic in topics" :key="topic.id" class="inline mr-4">

            <Pill :href="route('posts.index', { topic: topic.slug })"
            :filled="topic.id === selectedTopic?.id">
                {{ topic.name }}
            </Pill>
            
                </li>
            </menu>
        
        <ul class="divide-y mt-4">
            <li 
            v-for="post in posts.data" 
            :key="post.id" 
            class="flex flex-col md:flex-row justify-between items-baseline py-4 px-2">

                <Link :href="post.routes.show" 
                class="group">
                <span class="font-bold text-lg group-hover:text-indigo-500">{{ post.title }}</span>
                <span class="block pt-1 text-sm text-gray-600"> {{ formattedData(post) }} ago by {{ post.user.name }}</span>
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
import { Link } from '@inertiajs/vue3';
import { formatDistance, parseISO } from "date-fns";
import { relativeDate } from "@/Utilities/date.js";
import { onMounted } from 'vue';
import PageHeading from '@/Components/PageHeading.vue';
import Pill from '@/Components/Pill.vue';


const props = defineProps(['posts', 'topics', 'selectedTopic']);  // ← Capture props!
const formattedData = (post) => formatDistance(parseISO(post.created_at), new Date());

//onMounted(() => {
//    console.log('Posts prop:', props.posts);
// });
</script>