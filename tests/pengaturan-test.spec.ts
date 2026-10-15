import { test, expect } from '@playwright/test';

const BASE = '/cloud-simulasimandiri';

test('pengaturan-test: login to wp-admin, go to pengaturan test, click save changes', async ({ page }) => {
  test.setTimeout(120000);

  // Step 1: Login to wp-admin
  await page.goto(`${BASE}/wp-login.php`);
  await page.fill('#user_login', 'yokowasis');
  await page.fill('#user_pass', 'nihlah2010');
  await page.click('#wp-submit');
  await page.waitForURL(/wp-admin/);

  // Step 2: Go to Pengaturan Test
  await page.goto(`${BASE}/wp-admin/admin.php?page=pengaturan-test`);
  await expect(page.locator('h2')).toContainText('Pengaturan Test');

  // Step 3: Click Save Changes and wait for page to reload
  await page.click('#submit');
  await page.waitForLoadState('networkidle');

  // Step 4: Assert no fatal/error occurred
  await expect(page.locator('body')).not.toContainText('Fatal error');
  await expect(page.locator('body')).not.toContainText('There has been a critical error');
  await expect(page.locator('body')).not.toContainText('Unable to open file');
  await expect(page.locator('body')).not.toContainText('Gagal Menyimpan');
  await expect(page.locator('body')).not.toContainText('Permission denied');
});
