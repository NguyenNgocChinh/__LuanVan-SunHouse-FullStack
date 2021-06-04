<template>
    <div class="container-fuild">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div id="app" class="card-body">
                        <chat-app></chat-app>
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
