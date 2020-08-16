<template>
    <div>

        <h6 class="text-black text-xl pt-4">{{ requirement.numbering }} {{ requirement.name }}</h6>

        <nav class="bg-white px-8 pt-2 shadow-md">
            <div class="-mb-px flex justify-center">
                <a class="tab" href="#">
                    Home
                </a>
                <a class="tab" href="#">
                    Products
                </a>
                <a class="active-tab" href="#">
                    Discounts
                </a>
                <a class="tab last-tab" href="#">
                    Customers
                </a>
            </div>
        </nav>

        <v-row>
            <v-col cols="6" md="6">
                <v-list-item v-for="(value, propertyName) in firstList" v-bind:key="propertyName" two-line>
                    <v-list-item-content>
                        <v-list-item-title>{{ propertyName | titleCase }}</v-list-item-title>
                        <v-list-item-subtitle v-if="propertyName !== 'assignees'">{{ value }}</v-list-item-subtitle>
                        <div v-else v-for="name in value">
                            <div
                                class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">
                                <div class="text-xs font-normal leading-none max-w-full flex-initial">{{ name }}</div>
                            </div>
                        </div>

                    </v-list-item-content>
                </v-list-item>
            </v-col>

            <v-col cols="6" md="6">
                <v-list-item v-for="(value, propertyName) in secondList" v-bind:key="propertyName" two-line>
                    <v-list-item-content>
                        <v-list-item-title>{{ propertyName | titleCase }}</v-list-item-title>
                        <v-list-item-subtitle>{{ value }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-col>
        </v-row>

        <h6>Description</h6>
        <span v-html="requirement.description"></span>

        <!-- Attachments -->
        <h5>Attachments</h5>
        <attachment-list :requirement="requirement"></attachment-list>
        <!-- // Attachments -->

        <ul class="nav nav-pills">
            <li v-for="tab in tabs" v-bind:key="tab" class="nav-item">
                <a :class="'nav-link ' +  (currentTab === tab ? 'active' : '')"
                   href="#" @click.prevent="currentTab = tab">{{ tab | titleCase }}</a>
            </li>
        </ul>

        <div v-show="currentTab === 'comments'">
            <h5 class="text-black text-xl font-bold">Comments</h5>
            <comment-list :requirement="requirement" repository-type="requirement"/>
        </div>
    </div>

</template>

<script>
import requirementCommentRepository from "../../../repositories/requirementCommentRepository";
import dayjs from "dayjs";
import AttachmentList from "./../sections/AttachmentList";
import CommentList from "./../sections/CommentList";

export default {
    components: {CommentList, AttachmentList},
    data() {
        return {
            itemsColumn: ['email', 'assigned'],
            fileAttachment: null,
            commentsLoaded: false,
            attachments: [],
            comment: {},
            comments: [],
            tabs: ['comments', 'histories'],
            currentTab: 'comments'
        }
    },
    computed: {
        requirement() {
            return this.$store.getters['requirement/currentRequirement']
        },
        firstList() {
            return {
                // assignees: this.get(this.requirement, 'name', ''),
                assignees: this.requirement.assignees.map(requirement => requirement.name),
                created: dayjs(this.requirement.created_at).format('LLL'),
                updated: dayjs(this.requirement.updated_at).format('LLL')
            }
        },
        secondList() {
            return {
                priority: this.get(this.requirement, 'priority.title', ''),
                type: this.requirement.type
            }
        },
        capitalize(value) {
            if (!value) return '';
            return _.capitalize(value)
        }
    },
    methods: {
        get(data, column, defaultValue) {
            return _.get(data, column, defaultValue);
        }
    }
}
</script>

<style scoped>

</style>
