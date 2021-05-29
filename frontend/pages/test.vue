<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Tin nhắn</div>

                    <div id="app" class="card-body">
                        <chat-app :user="$auth.user"></chat-app>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    middleware: ['auth'],
}
</script>
