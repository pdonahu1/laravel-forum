<template>
<AppLayout>
    <Container>
        <ul class="divide-y">
            <li v-for="post in posts.data" :key="post.id" class="py-4 px-2">
                <Link :href="post.routes.show" class="group">
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

//import { route } from 'vendor/tightenco/ziggy/src/js';


const props = defineProps(['posts']);  // ← Capture props!
const formattedData = (post) => formatDistance(parseISO(post.created_at), new Date());

//onMounted(() => {
//    console.log('Posts prop:', props.posts);
// });
</script>