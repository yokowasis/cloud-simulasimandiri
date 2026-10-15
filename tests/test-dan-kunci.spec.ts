import { test, expect } from '@playwright/test';

const BASE = '/cloud-simulasimandiri';
const TEST_CODE = 'PWTESTAUTO';

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

test.describe.serial('Tambah Test & Tambah Kunci Management', () => {
  test.setTimeout(120000);

  test('1. add test (from menu tambah test)', async ({ page }) => {
    await ensureLoggedIn(page);

    // Verify Database Test menu and navigate to Tambah Test
    await page.goto(`${BASE}/wp-admin/admin.php?page=bimasoft_database_tambah_test_slug`);
    await expect(page.locator('h2')).toContainText('Tambah Test');

    // Fill test details
    await page.fill('#testKode', TEST_CODE);
    await page.fill('#testNama', 'Playwright Automated Test');
    await page.fill('#testStatus', 'PW Status');
    await page.fill('#testSubtest', 'PW Subtest');
    await page.fill('#testTanggal', '2026-10-15');
    await page.fill('#testWaktu', '08:00');
    await page.fill('#testAlokasi', '90');
    await page.selectOption('#testShuffle', '1');
    await page.selectOption('#testShuffle2', '1');
    await page.fill('#testJumlahSoal', '40');
    await page.fill('#testDikerjakan', '40');

    // Submit form
    await page.click('#simpanTestBtn');

    // Assert success message
    const resultDiv = page.locator('#testResult');
    await expect(resultDiv).toBeVisible();
    await expect(resultDiv).toContainText('Data Test Berhasil di Simpan');

    // Verify test appears in Database Test list
    await page.goto(`${BASE}/wp-admin/admin.php?page=bimasoft_database_slug`);
    await page.waitForSelector('table.dataTables');
    const row = page.locator('table.dataTables tbody tr', { hasText: TEST_CODE });
    await expect(row).toBeVisible();
  });

  test('2. add answer keys (from menu tambah kunci)', async ({ page }) => {
    await ensureLoggedIn(page);

    // Navigate to Tambah Kunci
    await page.goto(`${BASE}/wp-admin/admin.php?page=bimasoft_database_tambah_kunci_slug`);
    await expect(page.locator('h2')).toContainText('Tambah Kunci');

    // Select the created test from dropdown
    await page.selectOption('#kunciKodeSelect', TEST_CODE);

    // Test single key entry (Question 1 -> A)
    await page.fill('#kunciNo', '1');
    await page.fill('#kunciVal', 'A');
    await page.fill('#kunciBobot', '1');
    await page.click('#simpanKunciBtn');

    const resultDiv = page.locator('#kunciResult');
    await expect(resultDiv).toBeVisible();
    await expect(resultDiv).toContainText('Kunci Jawaban Berhasil di Simpan');

    // Test batch key entry (Question 2 -> B, Question 3 -> C)
    await page.selectOption('#kunciKodeSelect', TEST_CODE);
    await page.fill('#kunciBatch', "2\tB\t1\n3\tC\t1");
    await page.click('#simpanKunciBtn');

    await expect(resultDiv).toContainText('Kunci Jawaban Berhasil di Simpan');
  });

  test('3. cleanup created test (from database test table)', async ({ page }) => {
    await ensureLoggedIn(page);

    // Navigate to Database Test list
    await page.goto(`${BASE}/wp-admin/admin.php?page=bimasoft_database_slug`);
    await page.waitForSelector('table.dataTables');

    // Locate test row
    const row = page.locator('table.dataTables tbody tr', { hasText: TEST_CODE });
    await expect(row).toBeVisible();

    // Click delete on row
    await row.locator('.rowdelete').click();
    await page.waitForTimeout(1500);

    // Reload page to verify deleted
    await page.reload();
    await page.waitForSelector('table.dataTables');
    const remainingRows = page.locator('table.dataTables tbody tr', { hasText: TEST_CODE });
    await expect(remainingRows).toHaveCount(0);
  });
});
