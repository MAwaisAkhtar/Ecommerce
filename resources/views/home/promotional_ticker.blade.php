<style>

.promotional-ticker {
    overflow: hidden;
    position: relative;
    width: 100%; /* Set the width to 100% of the container */
    height: 150px; /* Adjust the height as needed */
}

.promotions-container {
    display: flex;
    animation: ticker {{ count($promotions) * 4 }}s linear infinite;
}

.promotion-item {
    width: 150px; /* Set a fixed width for a square */
    margin-right: 10px; /* Add right margin for spacing */
    display: flex;
    align-items: center;
}

.promotion-item img {
    max-width: 100%;
    max-height: 100%;
}

@keyframes ticker {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-{{ (count($promotions) * 120) + 160 }}px); /* Adjust the value as needed */
    }
}

</style>

<div class="promotional-ticker">
    <div class="promotions-container">
        @foreach($promotions as $promotion)
            <div class="promotion-item">
                <img src="product/{{ $promotion->image }}" alt="Promotion Image">
            </div>
        @endforeach
    </div>
</div>