<template>
    <div>
        <h6 class="text-black text-xl pt-4 font-medium">{{ requirement.numbering }} {{ requirement.name }}</h6>

        <div v-if="lists.length" class="flex">
            <div v-for="(list, index) in lists" v-bind:key="index" class="flex-1 pl-1 mr-16">
                <div v-for="(value, propertyName) in list" v-bind:key="propertyName" class="flex-1 pl-1 mr-16 pt-2">
                    <div v-if="propertyName !== 'assignees'">
                        <div class="font-medium">{{ propertyName | titleCase }}</div>
                        <div class="text-gray-600 text-sm">{{ value }}</div>
                    </div>

                    <div v-else>
                        <div class="font-medium">{{ propertyName | titleCase }}</div>
                        <div class="grid grid-flow-row grid-cols-2 grid-rows-2 gap-1">
                            <div v-for="item in value"
                                 class="flex justify-center items-center m-1 font-medium px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">
                                <div class="text-xs font-normal leading-none max-w-full flex-initial">
                                    {{ item }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <h6 class="pt-4 font-medium">Description</h6>
        <span v-html="requirement.description"></span>


        <!-- Attachments -->
        <h5>Attachments</h5>
        <!--        <attachment-list :requirement="requirement"></attachment-list>-->
        <!-- // Attachments -->

        <nav class="px-1 pt-2">
            <div class="-mb-px flex justify-left">
                <a v-for="tab in tabs" class="tab" :class="currentTab === tab ? 'active-tab' : ''" href="#"
                   @click.prevent="currentTab = tab">
                    {{ tab | titleCase }}
                </a>
            </div>
        </nav>

        <div v-show="currentTab === 'comments'">
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
                type: this.requirement.type,
                hours_to_complete : this.requirement.hours_to_complete
            }
        },
        lists() {
            return [this.firstList, this.secondList]
        },
        capitalize(value) {
            if (!value) return '';
            return _.capitalize(value)
        },
        assignees() {
            return this.firstList.assignees
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
