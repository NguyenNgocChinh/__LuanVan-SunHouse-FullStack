<template>
    <div>
        <v-list three-line>
            <template v-for="(item, index) in items">
                <v-subheader v-if="item.header" :key="item.header" v-text="item.header"></v-subheader>

                <v-divider v-else-if="item.divider" :key="index" :inset="item.inset"></v-divider>

                <v-list-item v-else :key="item.title">
                    <v-list-item-avatar>
                        <v-img :src="item.avatar"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title v-html="item.title"></v-list-item-title>
                        <v-list-item-subtitle v-html="item.subtitle"></v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </template>
        </v-list>
        <v-alert dense text type="success">
            <a
                class="dark--text text-decoration-none"
                href="https://api.sunhouse.stuesports.info/api/baidang/"
                target="_blank"
                >TEST CSDL</a
            ></v-alert
        >
    </div>
</template>

<script>
export default {
    data: () => ({
        name: 'Members',
        items: [
            { header: 'Members' },
            {
                avatar: '/Member/Chinh.jpg',
                title: 'Nguyễn Ngọc Chinh',
                subtitle: `<span class="text--primary">DH17 &mdash; TH07</span> `,
            },
            { divider: true, inset: true },
            {
                avatar: '/Member/Hung.jpg',
                title: 'Phạm Minh Hùng',
                subtitle: `<span class="text--primary">DH17 &mdash; TH07</span> `,
            },
            { divider: true, inset: true },
            {
                avatar: '/Member/Manh.jpg',
                title: 'Nguyễn Văn Mạnh',
                subtitle: `<span class="text--primary">DH17 &mdash; TH07</span> `,
            },
            { divider: true, inset: true },
            {
                avatar: '/Member/Nhat.jpg',
                title: 'Trần Thị Ngọc Nhật',
                subtitle: `<span class="text--primary">DH17 &mdash; TH07</span> `,
            },
            { divider: true, inset: true },
            {
                avatar: '/Member/Nhuy.jpg',
                title: 'Nguyễn Thị Bích Nhuỵ',
                subtitle: `<span class="text--primary">DH17 &mdash; TH07</span> `,
            },
            { divider: true, inset: true },
        ],
    }),
}
</script>
