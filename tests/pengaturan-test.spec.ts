import { test, expect } from '@playwright/test';

const BASE = '/cloud-simulasimandiri';

async function ensureLoggedIn(page) {
  await page.goto(`${BASE}/wp-login.php`);
  if (page.url().includes('wp-admin')) {
    return;
  }
  await page.waitForSelector('#user_login');
  await page.fill('#user_login', 'yokowasis');
  await page.fill('#user_pass', 'nihlah2010');
  await page.click('#wp-submit');
  await page.waitForURL(/wp-admin/);
}

test('pengaturan-test: login to wp-admin, go to pengaturan test, click save changes', async ({ page }) => {
  test.setTimeout(120000);

  // Step 1: Login to wp-admin
  await ensureLoggedIn(page);

  // Step 2: Go to Pengaturan Test
  await page.goto(`${BASE}/wp-admin/admin.php?page=pengaturan-test`);
  await expect(page.locator('h2')).toContainText('Pengaturan Test');

  // Step 3: Verify all fields have non-empty default values
  const checkNonEmptyFields = async () => {
    const emptyCount = await page.evaluate(() => {
      const inputs = Array.from(document.querySelectorAll('.bimasoft_pages form table input[type=text], .bimasoft_pages form table select, .bimasoft_pages form table textarea'));
      return inputs.filter(el => !el.value || el.value.trim() === '').length;
    });
    expect(emptyCount).toBe(0);
  };

  await checkNonEmptyFields();

  // Step 4: Click Save Changes and wait for page to reload
  await page.click('#submit');
  await page.waitForLoadState('networkidle');

  // Step 5: Assert no fatal/error occurred
  await expect(page.locator('body')).not.toContainText('Fatal error');
  await expect(page.locator('body')).not.toContainText('There has been a critical error');
  await expect(page.locator('body')).not.toContainText('Unable to open file');
  await expect(page.locator('body')).not.toContainText('Gagal Menyimpan');
  await expect(page.locator('body')).not.toContainText('Permission denied');

  // Step 6: Verify all fields remain non-empty after saving
  await checkNonEmptyFields();
});
