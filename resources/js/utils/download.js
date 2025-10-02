/**
 * Скачивает TXT файл с адресами
 * @param {Array|string} addresses - Массив адресов или один адрес для скачивания
 * @param {string} filename - Имя файла (опционально)
 * @returns {boolean} - true если успешно, false если ошибка
 */
export const downloadTxtFile = (addresses, filename = null) => {
    try {
        // Нормализуем адреса в массив
        const addressList = Array.isArray(addresses) ? addresses : [addresses];
        
        // Извлекаем адреса из объектов или используем как есть
        const extractedAddresses = addressList.map(addr => {
            return typeof addr === 'object' && addr.address ? addr.address : addr;
        });
        
        // Создаем содержимое файла
        const content = extractedAddresses.join('\n');
        
        // Генерируем имя файла если не указано
        const defaultFilename = filename || `vornis_addresses_${new Date().toISOString().split('T')[0]}.txt`;
        
        // Создаем и скачиваем файл
        const blob = new Blob([content], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = defaultFilename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
        
        return true;
    } catch (error) {
        console.error('Ошибка при скачивании файла:', error);
        return false;
    }
};

/**
 * Скачивает JSON файл с адресами в формате VORNIS
 * @param {Array|string} addresses - Массив адресов или один адрес
 * @param {string} filename - Имя файла (опционально)
 * @returns {boolean} - true если успешно, false если ошибка
 */
export const downloadJsonFile = (addresses, filename = null) => {
    try {
        const addressList = Array.isArray(addresses) ? addresses : [addresses];
        
        // Форматируем в формат VORNIS
        const formatted = addressList.map((addr, idx) => {
            const addressValue = typeof addr === 'object' && addr.address ? addr.address : addr;
            
            return {
                trackedWalletAddress: addressValue,
                name: `VORNIS (${idx + 1})`,
                emoji: "⚠️",
                alertsOnToast: false,
                alertsOnBubble: true,
                alertsOnFeed: false,
                sound: "none",
            };
        });

        const content = JSON.stringify(formatted, null, 2);
        const defaultFilename = filename || `vornis_addresses_${new Date().toISOString().split('T')[0]}.txt`;
        
        const blob = new Blob([content], { type: 'application/json' });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = defaultFilename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
        
        return true;
    } catch (error) {
        console.error('Ошибка при скачивании JSON файла:', error);
        return false;
    }
};
