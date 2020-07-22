<template>
    <div v-if="loaded">
        <button @click="addNode">Add Node</button>
        <vue-tree-list
            @click="onClick"
            @change-name="onChangeName"
            @delete-node="onDel"
            @add-node="onAddNode"
            :model="modulesData"
            default-tree-node-name="new module"
            default-leaf-node-name="new requirement"
            v-bind:default-expanded="false"
        >
            <template v-slot:leafNameDisplay="slotProps">
        <span>
          {{slotProps.model.numbering}} {{ slotProps.model.title }}
        </span>
            </template>
            <span class="icon" slot="addTreeNodeIcon">📂</span>
            <span class="icon" slot="addLeafNodeIcon">＋</span>
            <span class="icon" slot="editNodeIcon">📃</span>
            <span class="icon" slot="delNodeIcon">✂️</span>
            <span class="icon" slot="leafNodeIcon">🍃</span>
            <span class="icon" slot="treeNodeIcon">🌲</span>
        </vue-tree-list>
        <pre>
      {{newTree}}
    </pre>

    </div>
</template>

<script>
    import {VueTreeList, Tree, TreeNode} from 'vue-tree-list';

    export default {
        name: "RequirementList",
        props: {
            modules: {
                type: Array,
                default: () => []
            }
        },
        created() {
            this.setModules();
        },
        data() {
            return {
                // modulesData: new Tree(JSON.parse(JSON.stringify(this.modules))),
                modulesData : JSON.parse(JSON.stringify(this.modules)),
                newTree: {},
                loaded : false,
                data: new Tree([
                    {
                        name: 'Node 1',
                        id: 1,
                        pid: 0,
                        dragDisabled: true,
                        addTreeNodeDisabled: true,
                        addLeafNodeDisabled: true,
                        editNodeDisabled: true,
                        delNodeDisabled: true,
                        children: [
                            {
                                name: 'Node 1-2',
                                id: 2,
                                isLeaf: true,
                                pid: 1
                            }
                        ]
                    },
                    {
                        name: 'Node 2',
                        id: 3,
                        pid: 0,
                        disabled: true
                    },
                    {
                        name: 'Node 3',
                        id: 4,
                        pid: 0
                    }
                ])
            }
        },
        methods: {
            setModules() {
                if (this.modulesData.length) {

                    this.modulesData = new Tree(replaceKeysDeep(this.modulesData, {
                        requirements : 'children',
                        name : 'title'
                    }))
                    console.log(this.modulesData);

                    this.loaded = true;
                }

                function replaceKeysDeep(obj, keysMap) { // keysMap = { oldKey1: newKey1, oldKey2: newKey2, etc...
                    return _.transform(obj, function(result, value, key) { // transform to a new object

                        let currentKey = keysMap[key] || key; // if the key is in keysMap use the replacement, if not use the original key

                        result[currentKey] = _.isObject(value) ? replaceKeysDeep(value, keysMap) : value; // if the key is an object run it through the inner function - replaceKeys
                    });
                }
            },
            onDel(node) {
                console.log(node)
                node.remove()
            },

            onChangeName(params) {
                console.log(params)
            },

            onAddNode(params) {
                console.log(params)
            },

            onClick(params) {
                console.log(params)
            },

            addNode() {
                var node = new TreeNode({name: 'new node', isLeaf: false})
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
            }
        }
    }
</script>

