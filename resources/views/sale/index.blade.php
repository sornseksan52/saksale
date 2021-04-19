<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="https://blog.kamiceria.com/wp-content/uploads/2013/01/online-sale.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300&display=swap');
        #app{
            font-family: 'Sarabun', sans-serif;
            /* font-size : 16px !important; */
        }
        .v-data-table-header th {
            white-space: nowrap;
        }
    </style>

</head>
<body>
    <div id="app">
        <v-app>
            <v-container class="mt-2">
                <template>
                    <v-data-table
                        :headers="headers"
                        :items="desserts"
                        sort-by="calories"
                        class="elevation-1"
                        :items-per-page="-1"
                        mobile-breakpoint="0"
                        fixed-header
                        height="500"
                    >
                        <template v-slot:item.saleprice="{ item }">
                            @{{ formatNum(item.saleprice) }}
                        </template>
                        <template v-slot:item.buyprice="{ item }">
                            @{{ formatNum(item.buyprice) }}
                        </template>
                        <template v-slot:item.tranprice="{ item }">
                            @{{ formatNum(item.tranprice) }}
                        </template>
                        <template v-slot:item.buydate="{ item }">
                            @{{ formatDate(item.buydate) }}
                        </template>
                        <template v-slot:item.saledate="{ item }">
                            @{{ formatDate(item.saledate) }}
                        </template>
                        <template v-slot:item.profit="{ item }">
                            @{{ formatNum(item.profit) }}
                        </template>

                        <template v-slot:top>
                            <v-toolbar
                                flat
                            >
                                <v-toolbar-title>รายการขายสินค้าทั้งหมดของ (SEK)</v-toolbar-title>
                                    <v-divider
                                        class="mx-4"
                                        inset
                                        vertical
                                    ></v-divider>
                                    <v-spacer></v-spacer>
                                    <v-dialog
                                        v-model="dialog"
                                        max-width="500px"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                            color="primary"
                                            dark
                                            class="mb-2"
                                            v-bind="attrs"
                                            v-on="on"
                                            >
                                            New Item
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">
                                                    @{{ formTitle }}
                                                </span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col
                                                            cols="12"
                                                        >
                                                            <v-text-field
                                                            v-model="editedItem.productname"
                                                            label="ชื่อสินค้า"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                            v-model="editedItem.buyprice"
                                                            label="ราคาซื้อ"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                            v-model="editedItem.saleprice"
                                                            label="ราคาขาย"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <!-- <v-text-field
                                                            v-model="editedItem.buydate"
                                                            label="วันที่ซื้อ"
                                                            ></v-text-field> -->
                                                            <v-menu
                                                                ref="buydate"
                                                                v-model="buydate"
                                                                :close-on-content-click="false"
                                                                :nudge-right="40"
                                                                transition="scale-transition"
                                                                offset-y
                                                                min-width="auto"
                                                            >
                                                                <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field
                                                                    v-model="editedItem.buydate"
                                                                    label="วันที่ซื้อ"
                                                                    prepend-icon="mdi-calendar"
                                                                    readonly
                                                                    v-bind="attrs"
                                                                    v-on="on"
                                                                ></v-text-field>
                                                                </template>
                                                                <v-date-picker
                                                                    v-model="editedItem.buydate"
                                                                    @input="buydate = false"
                                                                ></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <!-- <v-text-field
                                                            v-model="editedItem.saledate"
                                                            label="วันที่ขาย"
                                                            ></v-text-field> -->
                                                            <v-menu
                                                                ref="saledate"
                                                                v-model="saledate"
                                                                :close-on-content-click="false"
                                                                :nudge-right="40"
                                                                transition="scale-transition"
                                                                offset-y
                                                                min-width="auto"
                                                            >
                                                                <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field
                                                                    v-model="editedItem.saledate"
                                                                    label="วันที่ขาย"
                                                                    prepend-icon="mdi-calendar"
                                                                    readonly
                                                                    v-bind="attrs"
                                                                    v-on="on"
                                                                ></v-text-field>
                                                                </template>
                                                                <v-date-picker
                                                                    v-model="editedItem.saledate"
                                                                    @input="saledate = false"
                                                                ></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                            v-model="editedItem.tranprice"
                                                            label="ค่าขนส่ง"
                                                            ></v-text-field>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="close"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="save"
                                                >
                                                    Save
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <v-dialog v-model="dialogDelete" max-width="500px">
                                        <v-card>
                                            <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                                            <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                            <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                            <v-spacer></v-spacer>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>

                                </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="editItem(item)"
                                >
                                    mdi-pencil
                                </v-icon>
                                <!-- <v-icon
                                    small
                                    @click="deleteItem(item)"
                                >
                                    mdi-delete
                                </v-icon> -->
                            </template>
                            <template v-slot:no-data>
                                <v-btn
                                    color="primary"
                                    @click="getdata"
                                >
                                    Reset
                                </v-btn>
                        </template>

                        <template slot="body.append">
                            <tr>
                                <th class="title">Totals</th>
                                <th class="title pink--text">
                                    <v-layout justify-end>
                                        @{{ sumField('buyprice') }}
                                    </v-layout>
                                </th>
                                <th class="title green--text">
                                    <v-layout justify-end>@{{ sumField('saleprice') }}</v-layout>
                                </th>
                                <th class="title warning--text">
                                    <v-layout justify-end>@{{ sumField('tranprice') }}</v-layout>
                                </th>
                                <th class="title green--text">
                                    <v-layout justify-end>@{{ sumField('profit') }}</v-layout>
                                </th>
                            </tr>
                        </template>

                    </v-data-table>
                 </template>

            </v-container>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
    <script>

    var app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: vm => ({
            headers: [
                {
                text: 'ชื่อสินค้า',
                    align: 'start',
                    sortable: false,
                    value: 'productname',
                },
                { text: 'ราคาซื้อ', value: 'buyprice' ,align : 'end'},
                { text: 'ราคาขาย', value: 'saleprice' ,align : 'end'},
                { text: 'ค่าขนส่ง', value: 'tranprice' ,align : 'end'},
                { text: 'กำไร', value: 'profit' ,align : 'end'},
                { text: 'วันที่ซื้อ',  value: 'buydate' ,align : 'center'},
                { text: 'วันที่ขาย', value: 'saledate' ,align : 'center'},
                { text: 'Actions', value: 'actions', sortable: false ,align : 'center'},
            ],
            dialog: false,
            dialogDelete: false,
            desserts: [],
            editedIndex: -1,
            editedItem: {},
            defaultItem: {},
            date: new Date().toISOString().substr(0, 10),
            date2: new Date().toISOString().substr(0, 10),
            saledate : false,
            buydate : false,

        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },

            computedDateFormatted () {
                return this.formatDate(this.date)
            },
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
            dialogDelete (val) {
                val || this.closeDelete()
            },
        },

        created () {
            this.getdata()
        },

        methods: {

            getdata :  async function(){

                let res = await this.axios_post('sale/getdata',{})
                if(res.status == '200'){
                    this.desserts  = res.data
                    console.log(res.data);
                }

            },

            sumField(key) {
                return this.formatNum(this.desserts.reduce((a, b) => parseFloat(a) + (parseFloat(b[key]) || 0), 0))
            },

            mangedata : async function(type = '', obj){
                let res = await this.axios_post('sale/mangedata',{type : type , obj : obj})
                // this.getdata()
            },

            formatDate (date) {
                return moment(date).format('DD/MM/YYYY')
            },

            formatNum (num){
                return numeral(num).format('0,0.00')
            },

            editItem (item) {
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem (item) {
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            },

            deleteItemConfirm () {
                this.desserts.splice(this.editedIndex, 1)
                this.closeDelete()
            },

            close () {
                this.dialog = false
                this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                })
            },

            closeDelete () {
                this.dialogDelete = false
                this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                })
            },

            save : async function() {
                let type = ''
                if (this.editedIndex > -1) {
                    Object.assign(this.desserts[this.editedIndex], this.editedItem)
                    type = 'update'
                } else {
                    this.desserts.push(this.editedItem)
                    type = 'insert'
                }
                await this.mangedata(type,this.editedItem)
                this.close()
            },

            axios_post : async function(post_url, post_data){
                let response = [];
                try {
                    response = await axios(
                        {
                            method: 'post',
                            url: post_url,
                            data: post_data,
                            headers: {
                                'Content-type': 'application/json; charset=UTF-8'
                            }
                        }
                    );
                } catch (error) {
                    console.log(error);
                }
                return response;
            }
        },

    })
  </script>

</body>
</html>
