<template>
    <div>
        <BaiDangHot />
        <ChoThue />
        <RaoBan />
    </div>
</template>

<script>
import BaiDangHot from "@/components/BaiDang/BaiDangHot";
import ChoThue from "@/components/BaiDang/ChoThue";
import RaoBan from "@/components/BaiDang/RaoBan";

export default {
    name: "Index",
    components: { BaiDangHot, ChoThue, RaoBan },
    layout: "default",
};
</script>
