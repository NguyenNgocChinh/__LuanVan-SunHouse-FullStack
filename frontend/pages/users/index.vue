<template>
    <v-container>
        <section class="wrapper">
            <ul class="tabs">
                <li class="active"><i class="bx bx-user"></i> Thông tin cá nhân</li>
                <li><i class="bx bx-lock-alt"></i> Đổi mật khẩu</li>
            </ul>

            <ul class="tab__content">
                <li class="active">
                    <div class="content__wrapper">
                        <h2 class="text-color">Pick a color</h2>
                        TAB 1
                    </div>
                </li>
                <li>
                    <div class="content__wrapper">
                        <h2 class="text-color">TAB 2</h2>
                    </div>
                </li>
            </ul>
        </section>
    </v-container>
</template>
<script>
export default {
    layout: 'user',
    data: () => {
        return {
            isShowMenu: true,
        }
    },
    head: {
        link: [{ href: require('~/assets/css/profileUser/detailUser.css'), rel: 'stylesheet' }],
    },
    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 1)
        window.$(document).ready(function () {
            // Variables
            let clickedTab = window.$('.tabs > .active')
            const tabWrapper = window.$('.tab__content')
            let activeTab = tabWrapper.find('.active')
            let activeTabHeight = activeTab.outerHeight()

            // Show tab on page load
            activeTab.show()

            // Set height of wrapper on page load
            tabWrapper.height(activeTabHeight)

            window.$('.tabs > li').on('click', function () {
                // Remove class from active tab
                window.$('.tabs > li').removeClass('active')

                // Add class active to clicked tab
                window.$(this).addClass('active')

                // Update clickedTab variable
                clickedTab = window.$('.tabs .active')

                // fade out active tab
                activeTab.fadeOut(250, function () {
                    // Remove active class all tabs
                    window.$('.tab__content > li').removeClass('active')

                    // Get index of clicked tab
                    const clickedTabIndex = clickedTab.index()

                    // Add class active to corresponding tab
                    window.$('.tab__content > li').eq(clickedTabIndex).addClass('active')

                    // update new active tab
                    activeTab = window.$('.tab__content > .active')

                    // Update variable
                    activeTabHeight = activeTab.outerHeight()

                    // Animate height of wrapper to new tab height
                    tabWrapper
                        .stop()
                        .delay(50)
                        .animate(
                            {
                                height: activeTabHeight,
                            },
                            500,
                            function () {
                                // Fade in active tab
                                activeTab.delay(50).fadeIn(250)
                            }
                        )
                })
            })

            // Variables
            const colorButton = window.$('.colors li')

            colorButton.on('click', function () {
                // Remove class from currently active button
                window.$('.colors > li').removeClass('active-color')

                // Add class active to clicked button
                window.$(this).addClass('active-color')

                // Get background color of clicked
                const newColor = window.$(this).attr('data-color')

                // Change background of everything with class .bg-color
                window.$('.bg-color').css('background-color', newColor)

                // Change color of everything with class .text-color
                window.$('.text-color').css('color', newColor)
            })
        })
    },
}
</script>
<style scoped>
.v-application ul,
.v-application ol {
    padding-left: unset;
}
</style>
