<?php
if (!isset($categoryItems) || !is_array($categoryItems) || empty($categoryItems)) {
    $categoryItems = [['name' => '', 'description' => '']];
}
?>
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <label class="block text-sm font-semibold text-gray-600">Öğeler</label>
        <button type="button" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800" data-category-item-add>+ Öğe ekle</button>
    </div>
    <div class="space-y-4" data-category-items>
        <?php foreach ($categoryItems as $item): ?>
            <div class="flex flex-col gap-3 rounded-xl border border-gray-200 p-4 md:flex-row md:items-center" data-category-item-row>
                <div class="flex-1 w-full">
                    <label class="text-xs uppercase tracking-wide text-gray-400">Başlık *</label>
                    <input type="text" name="item_name[]" value="<?= htmlspecialchars($item['name'] ?? '') ?>"
                           class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" required>
                </div>
                <div class="flex-1 w-full">
                    <label class="text-xs uppercase tracking-wide text-gray-400">Açıklama</label>
                    <input type="text" name="item_description[]" value="<?= htmlspecialchars($item['description'] ?? '') ?>"
                           class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div class="md:w-auto flex justify-end">
                    <button type="button" class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-600"
                            data-category-item-remove>Sil</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<template id="category-item-template">
    <div class="flex flex-col gap-3 rounded-xl border border-gray-200 p-4 md:flex-row md:items-center" data-category-item-row>
        <div class="flex-1 w-full">
            <label class="text-xs uppercase tracking-wide text-gray-400">Başlık *</label>
            <input type="text" name="item_name[]" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" required>
        </div>
        <div class="flex-1 w-full">
            <label class="text-xs uppercase tracking-wide text-gray-400">Açıklama</label>
            <input type="text" name="item_description[]" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>
        <div class="md:w-auto flex justify-end">
            <button type="button" class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-600" data-category-item-remove>Sil</button>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var container = document.querySelector('[data-category-items]');
    var addButton = document.querySelector('[data-category-item-add]');
    var template = document.getElementById('category-item-template');

    if (!container || !addButton || !template) {
        return;
    }

    function updateRemoveStates() {
        var rows = container.querySelectorAll('[data-category-item-row]');
        rows.forEach(function (row) {
            var removeBtn = row.querySelector('[data-category-item-remove]');
            if (!removeBtn) {
                return;
            }
            var disabled = rows.length === 1;
            removeBtn.disabled = disabled;
            removeBtn.classList.toggle('opacity-40', disabled);
            removeBtn.classList.toggle('cursor-not-allowed', disabled);
        });
    }

    function bindRemove(row) {
        var removeBtn = row.querySelector('[data-category-item-remove]');
        if (!removeBtn) {
            return;
        }
        removeBtn.addEventListener('click', function () {
            var rows = container.querySelectorAll('[data-category-item-row]');
            if (rows.length === 1) {
                return;
            }
            row.remove();
            updateRemoveStates();
        });
    }

    container.querySelectorAll('[data-category-item-row]').forEach(bindRemove);
    updateRemoveStates();

    addButton.addEventListener('click', function () {
        var fragment = template.content.cloneNode(true);
        var row = fragment.querySelector('[data-category-item-row]');
        bindRemove(row);
        container.appendChild(fragment);
        updateRemoveStates();
    });
});
</script>
