/**
 * Копирует адреса в буфер обмена в формате для VORNIS
 * @param {string|Array|Object} addresses - Адрес, массив адресов или объект с полем address для копирования
 * 
 * @example
 * // Копирование одного адреса
 * copyAddresses("0x123...")
 * 
 * // Копирование массива адресов
 * copyAddresses(["0x123...", "0x456..."])
 * 
 * // Копирование объекта с адресом
 * copyAddresses({address: "0x123..."})
 * 
 * // В шаблоне Vue
 * <button @click="copyAddresses(address)">Копировать</button>
 */
export const copyAddresses = (addresses) => {
    try {
        // Если адрес - строка или массив, обрабатываем соответственно
        const addressList = Array.isArray(addresses) ? addresses : [addresses];
        
        // Форматируем в нужный формат
        const formatted = addressList.map((addr, idx) => {
            // Если это объект с полем address, извлекаем адрес
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

        // Копируем в буфер обмена
        navigator.clipboard.writeText(JSON.stringify(formatted, null, 2));
        
        return true;
    } catch (error) {
        console.error('Ошибка при копировании адресов:', error);
        return false;
    }
};

/**
 * Копирует один адрес в буфер обмена
 * @param {string} address - Адрес для копирования
 */
export const copySingleAddress = (address) => {
    return copyAddresses([address]);
};
