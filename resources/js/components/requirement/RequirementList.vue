<template>
    <div>
        <!--        <button @click="addNode">Add New Module</button>-->

        <label class="primary-label" for="search-requirement">
            Search requirement and module
        </label>

        <input class="primary-input"
               v-model="searchRequirement"
               id="search-requirement" type="text" placeholder="Name">

        <vue-tree-list
            @click="onClick"
            @change-name="onChangeName"
            @delete-node="onDel"
            @add-node="onAddNode"
            @drop="onDrop"
            @drop-before="onDropBefore"
            @drop-after="onDropAfter"
            :model="treeListData"
            default-tree-node-name="new module"
            default-leaf-node-name="new requirement"
            v-bind:default-expanded="false"
        >
            <template v-slot:leafNameDisplay="slotProps">
        <span>
          {{ slotProps.model.numbering }} {{ slotProps.model.name }}
        </span>
            </template>
            <span class="icon" slot="addTreeNodeIcon">📂</span>
            <span class="icon" slot="addLeafNodeIcon">＋</span>
            <span class="icon" slot="editNodeIcon">📃</span>
            <!--            <span class="icon" slot="delNodeIcon">Edit</span>-->
            <!--            <span class="icon" slot="leafNodeIcon"></span>-->
            <span class="icon" slot="treeNodeIcon">📂</span>
            <!--            <template v-slot:editNodeIcon="slotProps">-->
            <!--                <button class="btn btn-primary">Edit</button>-->
            <!--            </template>-->
            <template slot="test">
                <button>TESt</button>
            </template>
            <button class="btn btn-primary">Edit</button>
        </vue-tree-list>


        <pre>
      {{ newTree }}
    </pre>

    </div>
</template>

<script>
import {VueTreeList, Tree, TreeNode} from 'vue-tree-list';
import CreateNewModule from "../modules/dialog/CreateNewModule";
import moduleRepository from "../../repositories/moduleRepository";
import requirementRepository from "../../repositories/requirementRepository";

export default {
    name: "RequirementList",
    components: {CreateNewModule, VueTreeList},
    data() {
        return {
            data: [],
            newTree: {},
            loaded: false,
            projectId: this.$route.params.project,
            searchRequirement: ""
        }
    },
    computed: {
        requirementList() {
            // vue tree list wont change if we use the computed property for this data
            // so we need to listen for changes and then retrieve the new requirement list
            // if it changes
            return this.$store.getters['requirement/requirementList'];
        },
        treeListData() {
            const requirementList = this.requirementList
                .map(element => {
                    return {
                        id: element.id,
                        name: element.name,
                        children: element.modules.concat(this.searchRequirement !== '' ?
                            element.requirements.filter(x => x.name.toLowerCase().indexOf(this.searchRequirement.toLowerCase()) > -1) :
                            element.requirements),
                        type: element.type,
                        parent_id: element.parent_id,
                        numbering: element.numbering,
                        created_at: element.created_at,
                        updated_at: element.created_at
                    }
                })
                .filter(x => x.name.toLowerCase().indexOf(this.searchRequirement.toLowerCase()) > -1 || x.children.length);

            return new Tree(replaceKeysDeep(
                requirementList, {}))

            function replaceKeysDeep(obj, keysMap) { // keysMap = { oldKey1: newKey1, oldKey2: newKey2, etc...
                return _.transform(obj, function (result, value, key) { // transform to a new object

                    if (result.hasOwnProperty('modules') && result.hasOwnProperty('requirements')) {
                        result.children = result.modules.concat(result.requirements);
                    }

                    if (result.type === 'requirement') result.isLeaf = true;

                    if (result.type === 'module') result.isLeaf = false;

                    result.addTreeNodeDisabled = true;
                    result.addLeafNodeDisable = true;
                    result.addLeafNodeDisabled = true;
                    // result.editNodeDisabled = true;
                    result.delNodeDisabled = true;

                    let currentKey = keysMap[key] || key; // if the key is in keysMap use the replacement, if not use the original key

                    result[currentKey] = _.isObject(value) ? replaceKeysDeep(value, keysMap) : value;
                    // if the key is an object run it through the inner function - replaceKeys
                });
            }
        }
    },
    watch: {
        // treeListData() {
        //     console.log('tree list data', this.treeListData);
        // }
    },
    methods: {
        onDel(node) {
            node.remove()
        },

        onChangeName(params) {
            console.log(params)
        },

        onAddNode(params) {

        },

        async onClick(params) {
            if (params.type === 'requirement') {
                this.$store.commit('requirement/setRequirement', params);
                await this.$store.dispatch('requirement/updateQueryParam');
            }
        },

        addNode() {
            console.log('add node');
            let node = new TreeNode({name: 'new node', isLeaf: false})
            if (!this.data.children) this.data.children = []
            this.data.addChildren(node)
        },

        getNewTree() {
            var vm = this

            function _dfs(oldNode) {
                var newNode = {}

                for (var k in oldNode) {
                    if (k !== 'children' && k !== 'parent') {
                        newNode[k] = oldNode[k]
                    }
                }

                if (oldNode.children && oldNode.children.length > 0) {
                    newNode.children = []
                    for (var i = 0, len = oldNode.children.length; i < len; i++) {
                        newNode.children.push(_dfs(oldNode.children[i]))
                    }
                }
                return newNode
            }

            vm.newTree = _dfs(vm.data)
        },

        onDrop(params) {
            // if the target and source node are the same, dont update the data
            // since the node doesnt change its position
            if (params.node.uuid !== params.target.uuid) {

                const payload = {
                    id: params.node.id,
                    name: params.node.name,
                    parent_id: params.target.id
                }

                params.node.type === 'requirement' ?
                    this.updateRequirementAfterDrop(payload) :
                    this.updateModuleAfterDrop(payload);
            }

        },

        onDropAfter(params) {
            // this.updateModuleAfterDrop(params);
            // console.log('ON DROP AFTER', params);
        },

        onDropBefore(params) {
            // if node is placed as top level node then set parent id to null
            // otherwise, use the parent id node
            const parent_id = params.target.parent_id !== null ? params.target.parent_id : null;

            this.updateModuleAfterDrop({
                id: params.node.id,
                name: params.node.name,
                parent_id: parent_id
            });
            // console.log('ON DROP BEFORE', params);
        },

        async updateModuleAfterDrop(payload) {

            try {
                await moduleRepository.update(payload.id, payload);

                await this.$store.dispatch('requirement/setRequirementList',
                    {project_id: this.projectId});

            } catch (e) {
                console.log(e);
            }
        },

        async updateRequirementAfterDrop(payload) {

            payload.module_id = payload.parent_id;
            delete payload.parent_id;

            try {
                await requirementRepository.updateParentId(payload.id, payload);

                await this.$store.dispatch('requirement/setRequirementList',
                    {project_id: this.projectId});

            } catch (e) {
                console.log(e);
            }
        },


    }
}
</script>

