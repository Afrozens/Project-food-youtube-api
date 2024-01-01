import { computed, h } from "vue";
import { TableColumnType } from "ant-design-vue";
import CellMain from "@/Components/Admin/Cell/CellMain.vue";

const columns = computed<TableColumnType[]>(() => {
    return [
        {
            title: "User",
            width: 200,
            dataIndex: "user",
            align: "center",
            key: "user",
            sorter: (a, b) => a.user.length - b.user.length,
            sortDirections: ["descend", "ascend"],
            customRender: function ({ record }) {
                return h("div", [
                    h(CellMain, {
                        data: record,
                    }),
                ]);
            },
        },
        {
            title: "Nickname",
            dataIndex: "nickname",
            width: 150,
            key: "nick",
            sorter: (a, b) => a.nickname.length - b.nickname.length,
            sortDirections: ["descend", "ascend"],
            align: "center",
        },
        {
            title: "Email",
            dataIndex: "email",
            width: 150,
            key: "status",
            sorter: (a, b) => a.email.length - b.email.length,
            sortDirections: ["descend", "ascend"],
            align: "center",
        },
        {
            title: "Actions",
            key: "action",
            fixed: "right",
            align: "center",
            width: 100,
        },
    ];
});

export { columns };
