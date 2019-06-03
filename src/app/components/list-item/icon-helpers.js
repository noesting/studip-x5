export const getItemTypeIconName = item => {
    if (!item) {
        return 'file_text';
    }

    switch (item.type) {
        case 'text':
            return 'file_text';
        case 'audio':
            return 'music';
        case 'video':
            return 'video2';
        case 'image':
            return 'image';
        default:
            return 'file_text';
    }
};
