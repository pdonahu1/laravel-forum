<template>
    <div class="sm:flex">
        <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
            <img :src="comment.user.profile_photo_url" class="h-10 w-10 rounded-full" />
        </div>
        <div class="flex-1">
            <div class="mt-1 prose prose-sm max-w-none" v-html="comment.html"></div>
            <span class="first-letter:uppercase block pt-1 text-xs text-gray-600">
                By {{ comment.user.name }} 
                {{ relativeDate(comment.created_at) }} } | <span class="text-indigo-500">{{ comment.likes_count }} likes</span>
            </span>

        <div class="mt-2 flex justify-end space-x-3 empty:hidden">

            <div v-if="$page.props.auth.user">
                <Link v-if="comment.can.like" preserve-scroll :href="route('likes.store', ['comment', comment.id])" method="post" class="inline-block text-gray-700 hover:text-indigo-400 transition-colors text-sm">
                    <HandThumbUpIcon class="size-6 px-1 inline-block"/>
                    <span class="sr-only">Like Comment</span>
                </Link>

                <Link v-else preserve-scroll :href="route('likes.destroy', ['comment', comment.id])" method="delete" class="inline-block text-gray-700 hover:text-indigo-400 transition-colors text-sm">
                    <HandThumbDownIcon class="size-6 px-1 inline-block"/>
                    <span class="sr-only">Unlike Comment</span>
                </Link>
            </div>



            <form v-if="comment.can?.update" @submit.prevent="$emit('edit', comment.id)">
                <button class="font-mono text-xs hover:font-semibold">Edit</button>
            </form>


            <form v-if="comment.can?.delete" @submit.prevent="$emit('delete', comment.id)">
                <button class="font-mono text-red-700 text-xs hover:font-semibold">Delete</button>
            </form>


            </div>
        </div>
    </div>
</template>

<script setup>
import { relativeDate } from "@/Utilities/date.js";
//import { router } from '@inertiajs/vue3';
//import { usePage } from '@inertiajs/vue3';
//import { computed } from 'vue';
import { defineEmits } from 'vue';
import { Link } from "@inertiajs/vue3";
import { HandThumbUpIcon, HandThumbDownIcon } from '@heroicons/vue/24/solid';

const props = defineProps(['comment']);

const emit = defineEmits(['edit', 'delete']);



// const canDelete = computed(() => props.comment.user.id === usePage().props.auth.user?.id);
</script>