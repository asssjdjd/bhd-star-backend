<template>
    <div>
        <NowShowingComponent />
        <!-- <SpecialComboComponent /> -->
        <!-- <DiscountComponent /> -->
        <ComingSoonComponent />
        <HotNewsComponent />
    </div>
</template>

<script>
import NowShowingComponent from './Home/NowShowingComponent.vue';
import SpecialComboComponent from './Home/SpecialComboComponent.vue';
import DiscountComponent from './Home/DiscountComponent.vue';
import ComingSoonComponent from './Home/CommingSoonComponent.vue';
import HotNewsComponent from './Home/HotNewsComponent.vue';

export default {
    name: 'HomeComponent',
    components: {
        NowShowingComponent,
        SpecialComboComponent,
        DiscountComponent,
        ComingSoonComponent,
        HotNewsComponent
    }
}
</script>
